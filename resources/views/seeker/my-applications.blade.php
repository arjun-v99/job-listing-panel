@extends('layouts.app')
@section('title', 'My Applications')

@section('content')
<h1 class="text-2xl font-bold mb-6">My Applications</h1>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-3 text-left">Job Title</th>
                <th class="px-4 py-3 text-left">Company</th>
                <th class="px-4 py-3 text-left">Location</th>
                <th class="px-4 py-3 text-left">Experience Required</th>
                <th class="px-4 py-3 text-left">Applied At</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($applications as $job)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-medium">{{ $job->job_title }}</td>
                <td class="px-4 py-3">{{ $job->recruiter->company_name }}</td>
                <td class="px-4 py-3">{{ $job->location->city }}</td>
                <td class="px-4 py-3">{{ $job->min_experience }}–{{ $job->max_experience }} yrs</td>
                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($job->pivot->applied_at)->format('d M Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-6 text-center text-gray-400">No applications yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $applications->links() }}</div>
@endsection
