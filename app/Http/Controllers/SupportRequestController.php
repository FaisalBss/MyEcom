<?php

namespace App\Http\Controllers;

use App\Models\SupportRequest;
use App\Models\SupportComment;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\StoreSupportRequest;
use App\Http\Requests\AdminUpdateSupportRequest;

class SupportRequestController extends Controller
{
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('contact.index');
    }

    public function previous()
    {
        $requests = auth()->user()
            ->supportRequests()
            ->latest()
            ->paginate(10);

        return view('contact.previous', compact('requests'));
    }

    public function create()
    {
        return view('contact.new');
    }

    public function store(StoreSupportRequest $request)
    {
        $validated = $request->validated();

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('support', 'public');
        }

        SupportRequest::create([
            'user_id'    => $request->user()->id,
            'message'    => $validated['message'],
            'image_path' => $path,
            'status'     => 'pending',
        ]);

        return redirect()
            ->route('contact.previous')
            ->with('success', 'We sent your request. Waiting for review.');
    }

    public function adminIndex()
    {
        $q = SupportRequest::with('user')->latest();
        if (request()->filled('status')) {
            $q->where('status', request()->string('status'));
        }
        $requests = $q->paginate(15)->withQueryString();

        return view('admin.support', compact('requests'));
    }

    public function adminShow($id)
    {
        $req = SupportRequest::with(['user', 'comments.admin'])->findOrFail($id);
        return view('admin.show', compact('req'));
    }

    public function adminUpdateStatus(AdminUpdateSupportRequest $request, $id)
    {
        $validated = $request->validated();

        $req = SupportRequest::findOrFail($id);
        $req->status = $validated['status'];
        $req->save();

        if (!empty($validated['comment'])) {
            SupportComment::create([
                'support_request_id' => $req->id,
                'admin_id' => auth()->id(),
                'body' => $validated['comment'],
            ]);
        }

        return back()->with('success', 'Updated successfully');
    }
}
