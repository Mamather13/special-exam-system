<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $email = $request->email;
    $password = $request->password;

    $user = DB::table('users')
        ->where('email', $email)
        ->where('password', $password)
        ->first();

    if ($user) {

        session([
            'user_id' => $user->id,
            'role' => $user->role
        ]);


        switch ($user->role) {

            case 'student':
                return redirect()->route('student.dashboard');

            case 'teacher':
                return redirect()->route('teacher.dashboard');

            case 'program_head':
                return redirect()->route('head.dashboard');

            case 'registrar':
                return redirect()->route('registrar.dashboard');
        }
    }

    return back()->with('error', 'Invalid email or password');
}



    public function logout()
    {
        session()->flush();
        return redirect('/');
    }
}
