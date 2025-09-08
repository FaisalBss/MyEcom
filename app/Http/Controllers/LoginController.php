<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function authinticated(Request $request, $user)
    {
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('mainpage');
    }
}
