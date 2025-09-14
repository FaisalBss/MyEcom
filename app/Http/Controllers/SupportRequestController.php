<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportRequest;
use App\Models\SupportComment;
use Illuminate\Pagination\Paginator;

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

    public function previous(Request $request)
    {
        $requests = $request->user()
            ->supportRequests()
            ->latest()
            ->paginate(10);

        return view('contact.previous', compact('requests'));
    }

    public function create()
    {
        return view('contact.new');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|min:10|max:5000',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
        ]);

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
            ->with('success', 'we sent your request Waiting for review');
    }



    public function adminIndex(Request $request)
    {
        $q = \App\Models\SupportRequest::with('user')->latest();
        if ($request->filled('status')) {
            $q->where('status', $request->string('status'));
        }
        $requests = $q->paginate(15)->withQueryString();

        return view('admin.support', compact('requests'));
    }

    public function adminShow($id)
{
    $req = SupportRequest::with(['user', 'comments.admin'])->findOrFail($id);
    return view('admin.show', compact('req'));
}

public function adminUpdateStatus(Request $request, $id)
{
    $data = $request->validate([
        'status'  => 'required|in:pending,in_progress,resolved,closed',
        'comment' => 'nullable|string|max:1000',
    ]);

    $req = SupportRequest::findOrFail($id);
    $req->status = $data['status'];
    $req->save();

    if (!empty($data['comment'])) {
        SupportComment::create([
            'support_request_id' => $req->id,
            'admin_id' => auth()->id(),
            'body' => $data['comment'],
        ]);
    }

    return back()->with('success', 'Updated successfully');
}


}
