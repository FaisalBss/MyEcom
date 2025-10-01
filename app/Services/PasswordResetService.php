<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class PasswordResetService
{
    public function createToken(string $email): string
    {
        $token = Str::random(60);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        return $token;
    }

    public function validateToken(string $email): bool
    {
        return DB::table('password_resets')->where('email', $email)->exists();
    }

    public function resetPassword(string $email, string $password): void
    {
        User::where('email', $email)->update([
            'password' => Hash::make($password),
        ]);

        DB::table('password_resets')->where('email', $email)->delete();
    }
}
