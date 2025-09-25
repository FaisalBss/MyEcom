<?php

namespace App\Services;

use App\Models\SupportRequest;
use App\Models\SupportComment;

class SupportService
{
    public function createRequest($user, array $data): SupportRequest
    {
        $path = null;
        if (isset($data['image'])) {
            $path = $data['image']->store('support', 'public');
        }

        return SupportRequest::create([
            'user_id'    => $user->id,
            'message'    => $data['message'],
            'image_path' => $path,
            'status'     => 'pending',
        ]);
    }

    public function getAllRequests(?string $status = null)
    {
        $q = SupportRequest::with('user')->latest();

        if ($status) {
            $q->where('status', $status);
        }

        return $q->paginate(15)->withQueryString();
    }

    public function getRequestWithDetails($id): SupportRequest
    {
        return SupportRequest::with(['user', 'comments.admin'])->findOrFail($id);
    }

    public function updateStatus($id, array $data): SupportRequest
    {
        $req = SupportRequest::findOrFail($id);
        $req->update(['status' => $data['status']]);

        if (!empty($data['comment'])) {
            SupportComment::create([
                'support_request_id' => $req->id,
                'admin_id'           => auth()->id(),
                'body'               => $data['comment'],
            ]);
        }

        return $req;
    }
}
