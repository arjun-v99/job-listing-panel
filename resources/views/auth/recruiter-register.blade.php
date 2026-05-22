@extends('layouts.app')
@section('title', 'Recruiter Registration')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Register as Recruiter</h2>

    <form method="POST" action="{{ route('register.recruiter.post') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Company Name</label>
            <input type="text" name="company_name" value="{{ old('company_name') }}"
                   class="w-full border rounded px-3 py-2 @error('company_name') border-red-500 @enderror">
            @error('company_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="w-full border rounded px-3 py-2 @error('email') border-red-500 @enderror">
            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Phone</label>
            <input type="text" name="phone" value="{{ old('phone') }}"
                   class="w-full border rounded px-3 py-2 @error('phone') border-red-500 @enderror">
            @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Address</label>
            <textarea name="address" rows="3"
                      class="w-full border rounded px-3 py-2 @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
            @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password"
                       class="w-full border rounded px-3 py-2 @error('password') border-red-500 @enderror">
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Register</button>
        <p class="text-center text-sm">Already have an account? <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Login</a></p>
    </form>
</div>
@endsection
