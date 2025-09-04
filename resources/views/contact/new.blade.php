@extends('Layouts.master')

@section('content')
<div class="container py-4">
  <h3>New Request</h3>

  @if($errors->any())
    <div class="alert alert-danger mt-3">
      <ul class="mb-0">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('contact.store') }}" method="POST" enctype="multipart/form-data" class="mt-3">
    @csrf
    <div class="form-group">
      <label for="message">Describe your issue</label>
      <textarea class="form-control" id="message" name="message" rows="6" required>{{ old('message') }}</textarea>
    </div>

    <div class="form-group">
      <label for="image">Attach an image (optional)</label>
      <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
      <small class="text-muted">Allowed: jpg, jpeg, png, webp, gif. Max 5MB.</small>
    </div>

    <button type="submit" class="btn btn-primary">Submit Request</button>
    <a href="{{ route('contact.previous') }}" class="btn btn-link">Previous Requests</a>
  </form>
</div>
@endsection
