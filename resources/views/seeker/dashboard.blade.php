@extends('layouts.app')
@section('title', 'Job Seeker Dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Welcome, {{ auth()->user()->name }}</h1>

<div class="grid grid-cols-1 gap-6 mb-8 max-w-xs">
    <div class="bg-white rounded shadow p-6 text-center">
        <p class="text-4xl font-bold text-indigo-600">{{ $stats['applied_count'] }}</p>
        <p class="text-gray-500 mt-1">Jobs Applied</p>
    </div>
</div>

<div class="flex gap-4">
    <a href="{{ route('seeker.find-jobs') }}"
       class="bg-indigo-600 text-white px-5 py-2 rounded hover:bg-indigo-700">Find Jobs</a>
    <a href="{{ route('seeker.my-applications') }}"
       class="bg-white border border-indigo-600 text-indigo-600 px-5 py-2 rounded hover:bg-indigo-50">My Applications</a>
</div>
@endsection
