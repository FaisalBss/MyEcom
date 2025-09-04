@extends('Layouts.master')

@section('content')
<div class="container py-4">
  <h3>Your Requests</h3>

  @if(session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
  @endif

  @if($requests->isEmpty())
    <div class="alert alert-info mt-3">لا توجد طلبات حتى الآن.</div>
    <a class="btn btn-primary" href="{{ route('contact.new') }}">New Request</a>
  @else
    <div class="table-responsive mt-3">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Message</th>
            <th>Status</th>
            <th>Image</th>
            <th>Created</th>
          </tr>
        </thead>
        <tbody>
          @foreach($requests as $r)
          <tr>
            <td>{{ $r->id }}</td>
            <td style="max-width: 420px;">
              <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                {{ $r->message }}
              </div>
            </td>
            <td>
              @php
                $badge = match($r->status){
                  'pending' => 'secondary',
                  'in_progress' => 'warning',
                  'resolved' => 'success',
                  'closed' => 'dark',
                  default => 'light'
                };
              @endphp
              <span class="badge badge-{{ $badge }}">{{ ucfirst(str_replace('_',' ',$r->status)) }}</span>
            </td>
            <td>
              @if($r->image_path)
                <a href="{{ asset('storage/'.$r->image_path) }}" target="_blank">View</a>
              @else
                —
              @endif
            </td>
            <td>{{ $r->created_at->format('Y-m-d H:i') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{ $requests->links() }}
  @endif
</div>
@endsection
