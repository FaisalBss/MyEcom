<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */


    public function store(LoginRequest $request): RedirectResponse
    {


        // $request->authenticate();
        // $request->session()->regenerate();

        // $user = $request->user();

        // return $user->is_admin ? redirect()->route('admin.dashboard') : redirect()->route('mainpage');

        $request->authenticate();

        $request->session()->regenerate();
        $user = $request->user();

        // if ($target = $user->is_admin ? route('admin.dashboard') : route('mainpage')) {
        //     return redirect()->intended($target);
        // } else {
        //     return redirect()->route('mainpage');
        // }
        $target = $user->is_admin ? route('admin.dashboard') : route('mainpage');
        return redirect()->intended($target);

       // return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
