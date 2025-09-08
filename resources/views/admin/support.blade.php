@extends('admin.admin')

@section('content')
<div class="container my-4" dir="rtl">
    <div class="row">
        <div class="col-12">

            {{-- الهيدر + التصفية --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Support Request</h4>

                <form method="GET" class="form-inline">
                    <label class="mr-2 small mb-0">Status</label>
                    <select name="status" class="form-control form-control-sm mr-2" style="min-width: 160px">
                        <option value="">All</option>
                        <option value="pending"     {{ request('status')==='pending' ? 'selected' : '' }}>Wating for review</option>
                        <option value="in_progress" {{ request('status')==='in_progress' ? 'selected' : '' }}>Under review</option>
                        <option value="resolved"    {{ request('status')==='resolved' ? 'selected' : '' }}>Solved</option>
                        <option value="closed"      {{ request('status')==='closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                    <button class="btn btn-sm btn-dark">Sort</button>
                </form>
            </div>

            {{-- الجدول --}}
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 text-nowrap">
                            <thead class="table-light">
                                <tr class="text-secondary small">
                                    <th class="text-center" style="width:70px">#</th>
                                    <th>User</th>
                                    <th>Category</th>
                                    <th>Summary</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Procedure</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $r)
                                    @php
                                        $status = $r->status ?? 'pending';
                                        $badge = [
                                            'pending'     => 'badge badge-warning',
                                            'in_progress' => 'badge badge-info',
                                            'resolved'    => 'badge badge-success',
                                            'closed'      => 'badge badge-secondary',
                                        ][$status] ?? 'badge badge-light';

                                        $category = $r->category ?? $r->type ?? $r->topic ?? '-';
                                        $message  = $r->message ?? $r->content ?? $r->body ?? '';
                                    @endphp
                                    <tr>
                                        <td class="text-center font-weight-bold">#{{ $r->id }}</td>
                                        <td>{{ $r->user->name ?? '—' }}</td>
                                        <td>{{ $category }}</td>
                                        <td class="text-muted">{{ \Illuminate\Support\Str::limit($message, 70) }}</td>
                                        <td class="text-center">
                                            <span class="{{ $badge }}">{{ $status }}</span>
                                        </td>
                                        <td class="text-center">{{ optional($r->created_at)->format('Y-m-d H:i') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.show', $r->id) }}" class="btn btn-sm btn-outline-primary">Show</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">There is no requests</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(method_exists($requests, 'links'))
                    <div class="card-footer bg-white">
                        {{ $requests->withQueryString()->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
