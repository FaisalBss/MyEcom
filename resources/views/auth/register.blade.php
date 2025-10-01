@extends('Layouts.master')

@section('content')
<div class="product-section mt-150 mb-150">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 text-center">
        <div class="section-title">
          <h3><span class="orange-text">Create</span> Account</h3>
          <p>Join us and start exploring our products.</p>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8 mb-5 mb-lg-0">
        <div class="form-title">
          <h2>Register</h2>
        </div>

        <div class="contact-form">
          <form method="POST" action="{{ route('register') }}" style="text-align:left">
            @csrf

            <p>
              <input type="text" style="width:100%" name="name" id="name"
                     placeholder="Full name" value="{{ old('name') }}">
              @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </p>

            <p>
              <input type="email" style="width:100%" name="email" id="email"
                     placeholder="Email" value="{{ old('email') }}">
              @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </p>

            <p style="display:flex;gap:2%">
              <input type="password" style="width:49%" name="password" id="password"
                     placeholder="Password">
              <input type="password" style="width:49%" name="password_confirmation"
                     id="password_confirmation" placeholder="Confirm password">
            </p>
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror

            <p><input type="submit" value="Create Account"></p>

            <p>Already have an account?
              <a href="{{ route('login') }}">Login</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
