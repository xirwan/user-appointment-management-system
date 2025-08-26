<x-user-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success"> 
            {{ session('success') }}
        </div>
    @endif
    
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1>Welcome, {{ $user->name }}</h1>
            <p class="mb-0">Your Timezone is: <strong>{{ $user->preferred_timezone }}</strong></p>
        </div>
        <div class="text-end">
            <h1>Current Time: <span id="current-time"></span></h1>
            <h5 class="mb-0">Current Date: <span id="current-date"></span></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Appointment List</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('appointments.index') }}">View</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Create Appointment</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('appointments.create') }}">Create</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>