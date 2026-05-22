@extends('layouts.app')
@section('title', 'Applied Jobs')

@section('content')
<h1 class="text-2xl font-bold mb-6">Applied Candidates</h1>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-3 text-left">Photo</th>
                <th class="px-4 py-3 text-left">Candidate</th>
                <th class="px-4 py-3 text-left">Phone</th>
                <th class="px-4 py-3 text-left">Experience</th>
                <th class="px-4 py-3 text-left">Job Title</th>
                <th class="px-4 py-3 text-left">Applied At</th>
                <th class="px-4 py-3 text-left">Resume</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($applications as $app)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">
                    <img src="{{ $app->jobSeeker->photo_url }}" alt="photo"
                         class="w-10 h-10 rounded-full object-cover">
                </td>
                <td class="px-4 py-3 font-medium">{{ $app->jobSeeker->user->name }}</td>
                <td class="px-4 py-3">{{ $app->jobSeeker->phone }}</td>
                <td class="px-4 py-3">{{ $app->jobSeeker->experience }} yr(s)</td>
                <td class="px-4 py-3">{{ $app->jobPost->job_title }}</td>
                <td class="px-4 py-3">{{ $app->applied_at->format('d M Y') }}</td>
                <td class="px-4 py-3">
                    <a href="{{ $app->jobSeeker->resume_url }}" target="_blank"
                       class="text-indigo-600 hover:underline text-xs">Download</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-4 py-6 text-center text-gray-400">No applications yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $applications->links() }}</div>
@endsection
