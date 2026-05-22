@extends('layouts.app')
@section('title', 'Find Jobs')

@section('content')
<h1 class="text-2xl font-bold mb-4">Find Jobs</h1>

<form method="GET" class="bg-white p-4 rounded shadow mb-6 grid grid-cols-2 md:grid-cols-5 gap-4">
    <input type="text" name="skills" value="{{ request('skills') }}"
           placeholder="Skills (comma separated)"
           class="border rounded px-3 py-2 text-sm col-span-2">

    <select name="company_id" class="border rounded px-3 py-2 text-sm">
        <option value="">All Companies</option>
        @foreach($companies as $co)
            <option value="{{ $co->id }}" {{ request('company_id') == $co->id ? 'selected' : '' }}>
                {{ $co->company_name }}
            </option>
        @endforeach
    </select>

    <input type="number" name="min_experience" value="{{ request('min_experience') }}" min="0"
           placeholder="Min Exp (yrs)"
           class="border rounded px-3 py-2 text-sm">

    <input type="number" name="max_experience" value="{{ request('max_experience') }}" min="0"
           placeholder="Max Exp (yrs)"
           class="border rounded px-3 py-2 text-sm">

    <select name="location_id" class="border rounded px-3 py-2 text-sm">
        <option value="">All Locations</option>
        @foreach($locations as $loc)
            <option value="{{ $loc->id }}" {{ request('location_id') == $loc->id ? 'selected' : '' }}>
                {{ $loc->city }}
            </option>
        @endforeach
    </select>

    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">Search</button>
    <a href="{{ route('seeker.find-jobs') }}"
       class="text-sm text-gray-500 px-4 py-2 border rounded hover:bg-gray-50 text-center">Reset</a>
</form>

<div class="space-y-4">
    @forelse($jobs as $job)
    <div class="bg-white rounded shadow p-5 flex items-start justify-between">
        <div>
            <h3 class="font-bold text-lg">{{ $job->job_title }}</h3>
            <p class="text-gray-600 text-sm">{{ $job->recruiter->company_name }} &middot; {{ $job->location->city }}</p>
            <p class="text-gray-500 text-sm mt-1">
                Experience: {{ $job->min_experience }}–{{ $job->max_experience }} yrs
                &nbsp;&middot;&nbsp; Skills: {{ $job->skills_string }}
            </p>
        </div>
        <div class="ml-4 flex-shrink-0">
            @if(in_array($job->id, $appliedIds))
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded text-sm">Applied</span>
            @else
                <form method="POST" action="{{ route('seeker.apply', $job) }}">
                    @csrf
                    <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">
                        Apply
                    </button>
                </form>
            @endif
        </div>
    </div>
    @empty
    <div class="text-center py-10 text-gray-400">No active jobs found matching your search.</div>
    @endforelse
</div>

<div class="mt-4">{{ $jobs->links() }}</div>
@endsection
