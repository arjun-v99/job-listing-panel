@extends('layouts.app')
@section('title', 'Find Candidates')

@section('content')
<h1 class="text-2xl font-bold mb-4">Find Candidates</h1>

<form method="GET" class="bg-white p-4 rounded shadow mb-6 grid grid-cols-2 md:grid-cols-5 gap-4">
    <input type="text" name="skills" value="{{ request('skills') }}"
           placeholder="Skills (comma separated)"
           class="border rounded px-3 py-2 text-sm col-span-2">

    <input type="number" name="notice_period" value="{{ request('notice_period') }}" min="0"
           placeholder="Notice Period ≤ (days)"
           class="border rounded px-3 py-2 text-sm">

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
    <a href="{{ route('recruiter.find-candidates') }}" class="text-sm text-gray-500 px-4 py-2 border rounded hover:bg-gray-50 text-center">Reset</a>
</form>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-3 text-left">Photo</th>
                <th class="px-4 py-3 text-left">Name</th>
                <th class="px-4 py-3 text-left">Phone</th>
                <th class="px-4 py-3 text-left">Experience</th>
                <th class="px-4 py-3 text-left">Notice Period</th>
                <th class="px-4 py-3 text-left">Skills</th>
                <th class="px-4 py-3 text-left">Location</th>
                <th class="px-4 py-3 text-left">Resume</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($candidates as $c)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">
                    <img src="{{ $c->photo_url }}" alt="photo"
                         class="w-10 h-10 rounded-full object-cover">
                </td>
                <td class="px-4 py-3 font-medium">{{ $c->user->name }}</td>
                <td class="px-4 py-3">{{ $c->phone }}</td>
                <td class="px-4 py-3">{{ $c->experience }} yr(s)</td>
                <td class="px-4 py-3">{{ $c->notice_period }} day(s)</td>
                <td class="px-4 py-3 max-w-xs truncate">{{ $c->skills_string }}</td>
                <td class="px-4 py-3">{{ $c->location->city }}</td>
                <td class="px-4 py-3">
                    <a href="{{ $c->resume_url }}" target="_blank"
                       class="text-indigo-600 hover:underline text-xs">Download</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-4 py-6 text-center text-gray-400">No candidates found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $candidates->links() }}</div>
@endsection
