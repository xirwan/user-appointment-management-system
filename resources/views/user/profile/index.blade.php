<x-user-layout>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if (session('success'))
                    <div id="alert" class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('profile.update', $user->id) }}">
                    @csrf
                    @method('patch')
                    <div class="card">
                        <div class="card-header">
                            <h4>Profile</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Masukan Nama" id="name" value="{{ ($user->name) }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Masukan Username" id="username" value="{{ ($user->username) }}">
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="preferred_timezone">Preferred Timezone</label>
                                <select name="preferred_timezone" id="preferred_timezone" class="form-select" required>
                                    @foreach ($timezones as $timezone)
                                        <option value="{{ $timezone }}" {{ old('preferred_timezone', $user->preferred_timezone) == $timezone ? 'selected' : '' }}>
                                            {{ str_replace('_', ' ', $timezone) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('preferred_timezone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-user-layout>