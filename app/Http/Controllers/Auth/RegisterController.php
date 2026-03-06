<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'organization_name' => 'required|string|max:100',
            'name'              => 'required|string|max:100',
            'email'             => 'required|email|unique:users',
            'password'          => 'required|min:8|confirmed',
        ]);

        $org = Organization::create([
            'name'           => $request->organization_name,
            'slug'           => Str::slug($request->organization_name) . '-' . Str::random(5),
            'plan'           => 'free',
            'employee_limit' => 10,
        ]);

        $user = User::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'password'        => Hash::make($request->password),
            'organization_id' => $org->id,
            'role'            => 'owner',
        ]);

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Welcome to PhishSim!');
    }
}
