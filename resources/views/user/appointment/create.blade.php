<x-user-layout>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Create New Appointment</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('appointments.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Appointment Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="e.g., Project Kick-off Meeting" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="start_time" class="form-label">Start Time</label>
                                    <input type="text" class="form-control @error('start_time') is-invalid @enderror" id="start_time_picker" name="start_time" value="{{ old('start_time') }}" placeholder="Select Date and Time" required>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="end_time" class="form-label">End Time</label>
                                    <input type="text" class="form-control @error('end_time') is-invalid @enderror" id="end_time_picker" name="end_time" value="{{ old('end_time') }}" placeholder="Select Date and Time" required>
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-text mb-3">
                                Select date and time according to your local timezone ({{ Auth::user()->preferred_timezone }}).
                            </div>
                            <div class="mb-3">
                                <label for="participants-select" class="form-label">Invite Participants</label>
                                <select name="participants[]" id="participants-select" class="form-select" multiple required></select>
                                <div class="form-text">
                                    Type a name or username to search and select multiple people.
                                </div>
                                @error('participants')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save Appointment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>