<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class AppointmentController extends Controller
{
    public function index() : View {
        $userId = Auth::user()->id;
        $user = User::find($userId);
        $appointments = $user->appointments()->with('creator', 'participants')->orderBy('start_time')->paginate(5);

        return view('user.appointment.index', compact('appointments'));
    }
    
    public function create() : View{
        $users = User::where('id', '!=', Auth::id())->get();

        return view('user.appointment.create', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'participants' => 'required|array',
            'participants.*' => 'exists:users,id',
        ]);

        $startTimeUTC = Carbon::parse($request->start_time, Auth::user()->preferred_timezone)->utc();
        $endTimeUTC = Carbon::parse($request->end_time, Auth::user()->preferred_timezone)->utc();

        $participantIds = $request->participants;
        $participantIds[] = Auth::id();
        $uniqueParticipantIds = array_unique($participantIds);

        $conflictingUser = User::whereIn('id', $uniqueParticipantIds)
            ->whereHas('appointments', function ($query) use ($startTimeUTC, $endTimeUTC) {
                $query->where('start_time', '<', $endTimeUTC)
                    ->where('end_time', '>', $startTimeUTC);
            })
            ->first();

        if ($conflictingUser) {
            return back()->withInput()->withErrors([
                'participants' => "Schedule conflict found. {$conflictingUser->name} already has an appointment in this time slot."
            ]);
        }
        
        $participants = User::find($uniqueParticipantIds);
        foreach ($participants as $participant) {
            $localTime = $startTimeUTC->copy()->setTimezone($participant->preferred_timezone);
            $hour = $localTime->hour;
            
            if ($hour < 9 || $hour >= 17) {
                return back()->withInput()->withErrors([
                    'start_time' => "The appointment time is outside of work hours for {$participant->name} ({$localTime->format('H:i')} their local time)."
                ]);
            }
        }

        $appointment = Appointment::create([
            'title' => $request->title,
            'creator_id' => Auth::id(),
            'start_time' => $startTimeUTC,
            'end_time' => $endTimeUTC,
        ]);

        $appointment->participants()->attach($uniqueParticipantIds);

        return redirect()->route('appointments.index')->with('success', 'Appointment successfully made!');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('q', '');

        $users = User::where('id', '!=', Auth::id())
                    ->where(function ($query) use ($searchTerm) {
                        $query->where('name', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('username', 'LIKE', "%{$searchTerm}%");
                    })
                    ->select('id', 'name', 'username')
                    ->limit(15)
                    ->get();

        $formattedUsers = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'text' => "{$user->name} ({$user->username})"
            ];
        });

        return response()->json($formattedUsers);
    }
}