<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required',
        'password' => 'required',
        'role' => 'required'
    ]);

    $email = $request->email;
    $password = md5($request->password);

    $user = DB::table('users')
        ->where('email', $email)
        ->where('password', $password)
        ->first();

    if ($user) {

        // 🔥 FIX ROLE NAME (IMPORTANT)
        if ($user->role !== $request->role) {
            return back()->with('error', 'Wrong role selected');
        }

        session([
            'user_id' => $user->id,
            'role' => $user->role
        ]);

        // 🔥 REDIRECT BASED ON ROLE
        if ($user->role == 'student') {
            return redirect('/student/dashboard');
        }

        if ($user->role == 'teacher') {
            return redirect('/teacher/dashboard');
        }

        if ($user->role == 'program_head') {
            return redirect('/program-head/dashboard');
        }
    }

    return back()->with('error', 'Invalid login credentials');
}

}

