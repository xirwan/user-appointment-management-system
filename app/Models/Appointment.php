<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Appointment extends Model
{
    protected $fillable = [
        'title',
        'creator_id',
        'start_time',
        'end_time',
    ];

    public function creator() {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function participants() {
        return $this->belongsToMany(User::class);
    }

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function getStartTimeAttribute($value)
    {
        if (Auth::check()) {
            return Carbon::parse($value)->setTimezone(Auth::user()->preferred_timezone);
        }

        return Carbon::parse($value);
    }

    public function getEndTimeAttribute($value)
    {
        if (Auth::check()) {
            return Carbon::parse($value)->setTimezone(Auth::user()->preferred_timezone);
        }
        
        return Carbon::parse($value);
    }
}
