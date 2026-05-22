@extends('layouts.app')
@section('title', 'Job Posts')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Job Posts</h1>
    <a href="{{ route('recruiter.job-posts.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">+ New Post</a>
</div>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-3 text-left">Title</th>
                <th class="px-4 py-3 text-left">Experience</th>
                <th class="px-4 py-3 text-left">Location</th>
                <th class="px-4 py-3 text-left">Skills</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($posts as $post)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-medium">{{ $post->job_title }}</td>
                <td class="px-4 py-3">{{ $post->min_experience }}–{{ $post->max_experience }} yrs</td>
                <td class="px-4 py-3">{{ $post->location->city }}</td>
                <td class="px-4 py-3 max-w-xs truncate">{{ $post->skills_string }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $post->isActive() ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ ucfirst($post->status) }}
                    </span>
                </td>
                <td class="px-4 py-3 flex gap-2">
                    <a href="{{ route('recruiter.job-posts.edit', $post) }}"
                       class="text-indigo-600 hover:underline text-xs">Edit</a>
                    <form method="POST" action="{{ route('recruiter.job-posts.destroy', $post) }}"
                          onsubmit="return confirm('Delete this job post?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:underline text-xs">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-6 text-center text-gray-400">No job posts yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $posts->links() }}</div>
@endsection
