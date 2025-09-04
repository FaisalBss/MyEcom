@extends('Layouts.master')

@section('content')
<div class="container py-4">
  <h3>Contact</h3>

  @if(session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger mt-3">{{ session('error') }}</div>
  @endif

  <div class="row mt-4">
    <div class="col-md-6 mb-3">
      <a href="{{ route('contact.previous') }}" class="btn btn-outline-primary btn-block">Previous Request</a>
    </div>
    <div class="col-md-6 mb-3">
      <a href="{{ route('contact.new') }}" class="btn btn-primary btn-block">New Request</a>
    </div>
  </div>
</div>
@endsection
