@extends('admin.admin')

@section('content')
<div class="container my-4" dir="rtl">
    <div class="row">
        <div class="col-lg-8 mx-auto">

            <div class="card shadow-sm mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Request information #{{ $req->id }}</h5>
                    <a href="{{ route('admin.contact') }}" class="btn btn-sm btn-outline-secondary">Back</a>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <span class="text-muted small">User: </span>
                        <span class="font-weight-bold">{{ $req->user->name ?? '—' }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted small">Category: </span>
                        <span>{{ $req->category ?? $req->type ?? $req->topic ?? '-' }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted small">Status: </span>
                        <span class="badge badge-pill
                            @if(($req->status ?? 'pending')==='pending') badge-warning
                            @elseif(($req->status ?? '')==='in_progress') badge-info
                            @elseif(($req->status ?? '')==='resolved') badge-success
                            @else badge-secondary @endif">
                            {{ $req->status ?? 'pending' }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <span class="text-muted small">Date: </span>
                        <span>{{ optional($req->created_at)->format('Y-m-d H:i') }}</span>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small mb-1">User Message</div>
                        <div class="border rounded p-3" style="white-space: pre-wrap">
                            {{ $req->message ?? $req->content ?? $req->body ?? '' }}
                        </div>
                    </div>

                    @php
                        use Illuminate\Support\Str;
                        use Illuminate\Support\Facades\Storage;

                        $raw = $req->image_path ?? $req->image ?? $req->attachment ?? $req->screenshot ?? null;
                        $imgUrl = null;

                        if ($raw) {
                            if (Str::startsWith($raw, ['http://','https://','/'])) {
                                $imgUrl = $raw;
                            } else {
                                $imgUrl = Storage::url($raw);
                            }
                        }
                    @endphp

                    @if($imgUrl)
                        <div class="mb-2">
                            <div class="text-muted small mb-1">Attachment</div>
                            <a href="{{ $imgUrl }}" target="_blank">
                                <img class="img-fluid rounded" style="max-height: 360px" src="{{ $imgUrl }}" alt="attachment">
                            </a>
                            <div class="mt-2">
                                <a class="btn btn-sm btn-outline-secondary" href="{{ $imgUrl }}" download>Download</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Update status / Admin comment</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.status', $req->id) }}">
                        @csrf
                        @method('PATCH')

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="small">Status</label>
                                <select name="status" class="form-control">
                                    <option value="pending"     @selected(($req->status ?? 'pending')==='pending')>Waiting for review</option>
                                    <option value="in_progress" @selected(($req->status ?? '')==='in_progress')>Under review</option>
                                    <option value="resolved"    @selected(($req->status ?? '')==='resolved')>Solved</option>
                                    <option value="closed"      @selected(($req->status ?? '')==='closed')>Closed</option>
                                </select>
                            </div>

                            <div class="form-group col-md-8">
                                <label class="small">Admin Comment (optional)</label>
                                <textarea name="comment" rows="2" class="form-control" placeholder="Write a comment to the user"></textarea>
                            </div>
                        </div>

                        <button class="btn btn-success">Save</button>
                    </form>

                    @if($errors->any())
                        <div class="alert alert-danger mt-3 mb-0 py-2 px-3">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success mt-3 mb-0 py-2 px-3">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>

            @php $comments = collect($req->comments ?? []); @endphp
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0">Comments</h6>
                </div>
                <div class="card-body">
                    @forelse($comments as $c)
                        <div class="media mb-3">
                            <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center mr-3" style="width:42px;height:42px;">
                                {{ \Illuminate\Support\Str::substr($c->admin->name ?? 'A', 0, 1) }}
                            </div>
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
                        <div class="text-muted">No comments yet.</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
