<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportRequest;

class SupportRequestController extends Controller
{
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

    // فورم طلب جديد
    public function create()
    {
        return view('contact.new');
    }

    // حفظ الطلب الجديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|min:10|max:5000',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('support', 'public'); // storage/app/public/support
        }

        SupportRequest::create([
            'user_id'    => $request->user()->id,
            'message'    => $validated['message'],
            'image_path' => $path,
            'status'     => 'pending',
        ]);

        return redirect()
            ->route('contact.previous')
            ->with('success', 'تم إرسال طلبك بنجاح.');
    }
}
