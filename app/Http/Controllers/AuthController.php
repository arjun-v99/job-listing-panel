<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecruiterRegisterRequest;
use App\Http\Requests\SeekerRegisterRequest;
use App\Models\JobSeeker;
use App\Models\Location;
use App\Models\Recruiter;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showSeekerRegister(): View
    {
        $locations = Location::orderBy('city')->get();
        return view('auth.seeker-register', compact('locations'));
    }

    public function registerSeeker(SeekerRegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
            'role'     => 'seeker',
        ]);

        $resumePath = $request->file('resume')->store('resumes', 'public');
        $photoPath  = $request->file('photo')->store('photos', 'public');

        JobSeeker::create([
            'user_id'       => $user->id,
            'phone'         => $request->phone,
            'experience'    => $request->experience,
            'notice_period' => $request->notice_period,
            'skills'        => $request->skills,
            'location_id'   => $request->location_id,
            'resume'        => $resumePath,
            'photo'         => $photoPath,
        ]);

        Auth::login($user);

        return redirect()->route('seeker.dashboard');
    }

    public function showRecruiterRegister(): View
    {
        return view('auth.recruiter-register');
    }

    public function registerRecruiter(RecruiterRegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name'     => $request->company_name,
            'email'    => $request->email,
            'password' => $request->password,
            'role'     => 'recruiter',
        ]);

        Recruiter::create([
            'user_id'      => $user->id,
            'company_name' => $request->company_name,
            'phone'        => $request->phone,
            'address'      => $request->address,
        ]);

        Auth::login($user);

        return redirect()->route('recruiter.dashboard');
    }

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return auth()->user()->isRecruiter()
                ? redirect()->intended(route('recruiter.dashboard'))
                : redirect()->intended(route('seeker.dashboard'));
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
