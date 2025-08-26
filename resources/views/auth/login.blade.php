<x-layout>
    @if (session('status'))
        <div id="alert" class="alert alert-danger"> 
            {{ session('status') }}
        </div>
    @endif

    <div class="wrapper">
      <a href="/"><h2>Login</h2></a>
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input-box">
          <input type="text" name="username" placeholder="Enter your username" value="{{ old('username') }}" required>
        </div>
        @error('username')
          <span class="error-message">{{ $message }}</span>
        @enderror
        <div class="input-box button">
          <input type="submit" value="Login">
        </div>
        <div class="text">
          <h3>Don't have an account yet? <a href="{{ route('register.form') }}">Register now</a></h3>
        </div>
      </form>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
            var alert = document.getElementById('alert');
            if (alert) {
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 3000);
            }
        });
    </script>
</x-layout>