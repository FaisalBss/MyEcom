<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\PasswordResetService;

class PasswordResetController extends Controller
{
    protected $service;

    public function __construct(PasswordResetService $service)
    {
        $this->service = $service;
    }

    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(ForgotPasswordRequest $request)
    {
        $token = $this->service->createToken($request->email);

        $link = url('/reset-password/' . $token . '?email=' . $request->email);

        return back()->with('status', "Reset link: $link");
    }

    public function showResetForm($token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => request()->email,
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        if (!$this->service->validateToken($request->email)) {
            return back()->withErrors(['email' => 'Invalid or expired token.']);
        }

        $this->service->resetPassword($request->email, $request->password);

        return redirect('/login')->with('status', 'Password reset successfully.');
    }
}
