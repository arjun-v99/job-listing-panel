@extends('layouts.app')
@section('title', 'Recruiter Dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Welcome, {{ auth()->user()->recruiter->company_name }}</h1>

<div class="grid grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded shadow p-6 text-center">
        <p class="text-4xl font-bold text-indigo-600">{{ $stats['total_posts'] }}</p>
        <p class="text-gray-500 mt-1">Total Job Posts</p>
    </div>
    <div class="bg-white rounded shadow p-6 text-center">
        <p class="text-4xl font-bold text-green-600">{{ $stats['active_posts'] }}</p>
        <p class="text-gray-500 mt-1">Active Posts</p>
    </div>
    <div class="bg-white rounded shadow p-6 text-center">
        <p class="text-4xl font-bold text-yellow-600">{{ $stats['total_applied'] }}</p>
        <p class="text-gray-500 mt-1">Total Applications</p>
    </div>
</div>

<div class="flex gap-4">
    <a href="{{ route('recruiter.job-posts.create') }}"
       class="bg-indigo-600 text-white px-5 py-2 rounded hover:bg-indigo-700">+ Post New Job</a>
    <a href="{{ route('recruiter.find-candidates') }}"
       class="bg-white border border-indigo-600 text-indigo-600 px-5 py-2 rounded hover:bg-indigo-50">Find Candidates</a>
    <a href="{{ route('recruiter.applied-jobs') }}"
       class="bg-white border border-indigo-600 text-indigo-600 px-5 py-2 rounded hover:bg-indigo-50">View Applications</a>
</div>
@endsection
