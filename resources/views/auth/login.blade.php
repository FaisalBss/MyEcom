@extends('Layouts.master')

@section('content')
<div class="product-section mt-150 mb-150">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 text-center">
        <div class="section-title">
          <h3><span class="orange-text">Account</span> Login</h3>
          <p>Welcome back! Sign in to continue.</p>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8 mb-5 mb-lg-0">
        <div class="form-title">
          <h2>Login</h2>
        </div>

        <div class="contact-form">
          <form method="POST" action="{{ route('login') }}" style="text-align:left">
            @csrf

            <p>
              <input type="email" style="width:100%" name="email" id="email"
                     placeholder="Email" value="{{ old('email') }}" required autofocus>
              @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </p>

            <p>
              <input type="password" style="width:100%" name="password" id="password"
                     placeholder="Password" required>
              @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </p>

            <p style="display:flex;justify-content:space-between;align-items:center">
              <label style="margin:0">
                <input type="checkbox" name="remember"> Remember me
              </label>
              <a href="{{ route('password.request') }}">Forgot password?</a>
            </p>

            <p><input type="submit" value="Sign in"></p>

            <p>Don’t have an account?
              <a href="{{ route('register') }}">Create one</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
