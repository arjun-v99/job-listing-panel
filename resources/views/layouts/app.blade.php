<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Job Listing Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<nav class="bg-indigo-700 text-white px-6 py-3 flex items-center justify-between">
    <span class="font-bold text-lg">Job Listing Panel</span>

    @auth
    <div class="flex items-center gap-4 text-sm">
        <span>{{ auth()->user()->name }}</span>

        @if(auth()->user()->isRecruiter())
            <a href="{{ route('recruiter.dashboard') }}" class="hover:underline">Dashboard</a>
            <a href="{{ route('recruiter.job-posts') }}" class="hover:underline">Job Posts</a>
            <a href="{{ route('recruiter.find-candidates') }}" class="hover:underline">Find Candidates</a>
            <a href="{{ route('recruiter.applied-jobs') }}" class="hover:underline">Applied Jobs</a>
        @else
            <a href="{{ route('seeker.dashboard') }}" class="hover:underline">Dashboard</a>
            <a href="{{ route('seeker.find-jobs') }}" class="hover:underline">Find Jobs</a>
            <a href="{{ route('seeker.my-applications') }}" class="hover:underline">My Applications</a>
        @endif

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-white text-indigo-700 px-3 py-1 rounded text-xs font-semibold hover:bg-indigo-100">Logout</button>
        </form>
    </div>
    @endauth
</nav>

<main class="max-w-6xl mx-auto py-8 px-4">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    @yield('content')
</main>

</body>
</html>
