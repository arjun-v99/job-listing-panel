@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

    <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="w-full border rounded px-3 py-2 @error('email') border-red-500 @enderror">
            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password"
                   class="w-full border rounded px-3 py-2 @error('password') border-red-500 @enderror">
            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember" class="text-sm">Remember me</label>
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Login</button>
    </form>

    <div class="mt-4 text-center text-sm space-y-1">
        <p>New here? Register as:
            <a href="{{ route('register.seeker') }}" class="text-indigo-600 hover:underline">Job Seeker</a>
            or
            <a href="{{ route('register.recruiter') }}" class="text-indigo-600 hover:underline">Recruiter</a>
        </p>
    </div>
</div>
@endsection
