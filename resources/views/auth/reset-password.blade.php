@extends('Layouts.master')

@section('content')
<div class="container">
  <h2>Reset Password</h2>
  <form method="POST" action="{{ route('password.store') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">

    <input type="password" name="password" placeholder="New Password" required>
    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
    <button type="submit">Reset Password</button>
  </form>
</div>
@endsection
