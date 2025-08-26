<x-layout>
    <div class="wrapper">
    <a href="/"><h2>Register</h2></a>
    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="input-box">
        <input type="text" name="name" placeholder="Enter your name" value="{{ old('name') }}" required>
      </div>
      @error('name')
          <span class="error-message">{{ $message }}</span>
      @enderror
      <div class="input-box">
        <input type="text" name="username" placeholder="Enter your username" value="{{ old('username') }}" required>
      </div>
      @error('username')
          <span class="error-message">{{ $message }}</span>
      @enderror
      <div class="input-box custom-select-wrapper">
    <div class="custom-select">
        <div class="custom-select-trigger">
            <span>-- Select Time Zone --</span>
            <div class="arrow"></div>
        </div>
        <div class="custom-options">
                @foreach ($timezones as $timezone)
                    <span class="custom-option" data-value="{{ $timezone }}">{{ str_replace('_', ' ', $timezone) }}</span>
                @endforeach
            </div>
        </div>
        
        <select name="preferred_timezone" required style="display: none;">
            <option value="" disabled selected>-- Select Time Zone --</option>
            @foreach ($timezones as $timezone)
                <option value="{{ $timezone }}">{{ $timezone }}</option>
            @endforeach
        </select>
    </div>
      <div class="input-box button">
        <input type="Submit" value="Register">
      </div>
      <div class="text">
        <h3>Already have an account? <a href="{{ route('login.form') }}">Login now</a></h3>
      </div>
    </form>

  </div>
</x-layout>