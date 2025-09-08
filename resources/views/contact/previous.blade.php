@extends('Layouts.master')

@section('content')
<div class="container py-4">
  <h3>Your Requests</h3>

  @if(session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
  @endif

  @if($requests->isEmpty())
    <div class="alert alert-info mt-3">No request so far</div>
    <a class="btn btn-primary" href="{{ route('contact.new') }}">New Request</a>
  @else
    <div class="table-responsive mt-3">
      <table class="table table-bordered align-middle">
        <thead>
          <tr>
            <th style="width:70px">#</th>
            <th>Message</th>
            <th>Status</th>
            <th>Admin Comment</th>
            <th>Image</th>
            <th style="width:160px">Created</th>
            <th style="width:120px">Thread</th>
          </tr>
        </thead>
        <tbody>
          @foreach($requests as $r)
            @php
              $comments = collect($r->comments ?? []);
              $latest   = $comments->sortByDesc('created_at')->first();
              $badge = match($r->status){
                'pending' => 'secondary',
                'in_progress' => 'warning',
                'resolved' => 'success',
                'closed' => 'dark',
                default => 'light'
              };
            @endphp

            <tr>
              <td class="fw-bold">#{{ $r->id }}</td>

              <td style="max-width: 420px;">
                <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                  {{ $r->message }}
                </div>
              </td>

              <td>
                <span class="badge badge-{{ $badge }}">
                  {{ ucfirst(str_replace('_',' ', $r->status)) }}
                </span>
              </td>

              <td style="max-width: 360px;">
                @if($latest)
                  <div class="small">
                    <strong>{{ $latest->admin->name ?? 'Admin' }}:</strong>
                    {{ \Illuminate\Support\Str::limit($latest->body, 80) }}
                  </div>
                  <div class="text-muted small">
                    {{ optional($latest->created_at)->format('Y-m-d H:i') }}
                  </div>
                @else
                  <span class="text-muted">No comment yet..</span>
                @endif
              </td>

              <td>
                @if(!empty($r->image_path))
                  <a href="{{ asset('storage/'.$r->image_path) }}" target="_blank">View</a>
                @else
                  —
                @endif
              </td>

              <td>{{ optional($r->created_at)->format('Y-m-d H:i') }}</td>

              <td class="text-center">
                <button class="btn btn-sm btn-outline-primary"
                        type="button"
                        data-toggle="collapse"
                        data-target="#req-{{ $r->id }}-comments"
                        aria-expanded="false"
                        aria-controls="req-{{ $r->id }}-comments">
                  Comments ({{ $comments->count() }})
                </button>
              </td>
            </tr>

            <tr class="bg-light">
              <td colspan="7" class="p-0">
                <div id="req-{{ $r->id }}-comments" class="collapse">
                  <div class="p-3">

                    <h6 class="mb-3">Conversation</h6>

                    <div class="media mb-3">
                      <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mr-3"
                           style="width:42px;height:42px;">{{ \Illuminate\Support\Str::substr($r->user->name ?? 'U', 0, 1) }}</div>
                      <div class="media-body">
                        <div class="d-flex justify-content-between">
                          <strong>{{ $r->user->name ?? 'User' }}</strong>
                          <span class="text-muted small">{{ optional($r->created_at)->format('Y-m-d H:i') }}</span>
                        </div>
                        <div class="mt-1" style="white-space: pre-wrap">{{ $r->message }}</div>
                      </div>
                    </div>
                    <hr>

                    @forelse($comments as $c)
                      <div class="media mb-3">
                        <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center mr-3"
                             style="width:42px;height:42px;">{{ \Illuminate\Support\Str::substr($c->admin->name ?? 'A', 0, 1) }}</div>
                        <div class="media-body">
                          <div class="d-flex justify-content-between">
                            <strong>{{ $c->admin->name ?? 'Admin' }}</strong>
                            <span class="text-muted small">{{ optional($c->created_at)->format('Y-m-d H:i') }}</span>
                          </div>
                          <div class="mt-1" style="white-space: pre-wrap">{{ $c->body }}</div>
                        </div>
                      </div>
                      <hr>
                    @empty
                      <div class="text-muted">No comments yet..</div>
                    @endforelse

                    <div class="mt-2">
                      <a class="btn btn-sm btn-primary" href="{{ route('contact.new') }}">New Request</a>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{ $requests->links() }}
  @endif
</div>
@endsection
