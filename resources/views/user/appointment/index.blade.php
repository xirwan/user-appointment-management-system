<x-user-layout>
    <div class="container-fluid px-4">
         @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        
        <h1 class="mt-4">My Appointments</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Here are all your upcoming and past appointments.</li>
        </ol>
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Create New Appointment
            </a>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-calendar-alt me-1"></i>
                Appointment List
            </div>
            <div class="card-body">
                @if($appointments->isEmpty())
                    <div class="text-center py-5">
                        <p class="lead">You have no appointments scheduled.</p>
                        <a href="{{ route('appointments.create') }}" class="btn btn-primary mt-3">Schedule Your First Appointment</a>
                    </div>
                @else
                    <div class="list-group">
                        @foreach ($appointments as $appointment)
                            <div class="list-group-item list-group-item-action flex-column align-items-start mb-3 border rounded">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ $appointment->title }}</h5>
                                    <small class="text-muted">{{ $appointment->start_time->format('D, j M Y, g:i A') }}</small>
                                </div>
                                <p class="mb-1">
                                    <strong>From:</strong> {{ $appointment->start_time->format('g:i A') }}
                                    <strong>To:</strong> {{ $appointment->end_time->format('g:i A') }}
                                    <span class="badge bg-secondary">{{ $appointment->start_time->diffForHumans() }}</span>
                                </p>
                                <p class="mb-1">
                                    <strong>Created by:</strong> {{ $appointment->creator->name }}
                                </p>
                                <div>
                                    <strong>Participants:</strong>
                                    @foreach ($appointment->participants as $participant)
                                        <span class="badge bg-info text-dark">{{ $participant->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                {{ $appointments->links() }}
            </div>
        </div>
    </div>
</x-user-layout>