@extends('Layouts.master')

@section('content')
<div class="product-section mt-150 mb-150">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 text-center">
        <div class="section-title">
          <h3><span class="orange-text">Forgot</span> Password</h3>
          <p>Enter your email address and we’ll send you a link to reset your password.</p>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8">
        <div class="contact-form">
          @if (session('status'))
              <div class="alert alert-success text-center">{{ session('status') }}</div>
          @endif

          <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
              <input type="email" name="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required>
              @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="d-flex justify-content-center">
              <button type="submit" class="btn btn-primary px-4 py-2">Send Reset Link</button>
            </div>
          </form>

          <div class="text-center mt-4">
            <a href="{{ route('login') }}">Back to Login</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
