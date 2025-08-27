@extends('Layouts.master')

@section('content')
<div class="product-section mt-150 mb-150">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="form-title mb-4">
          <h2>Edit Profile</h2>
        </div>
        <div class="contact-form">
          <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <p>
              <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" style="width:100%" required>
              @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </p>

            <p>
              <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" style="width:100%" required>
              @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </p>

            <p>
              <input type="password" name="password" placeholder="New password (leave blank to keep current)" style="width:100%">
              @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </p>

            <p>
              <input type="password" name="password_confirmation" placeholder="Confirm new password" style="width:100%">
            </p>

            <p><input type="submit" value="Update Profile"></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
