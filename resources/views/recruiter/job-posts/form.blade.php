@extends('layouts.app')
@section('title', isset($jobPost) ? 'Edit Job Post' : 'Create Job Post')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">{{ isset($jobPost) ? 'Edit Job Post' : 'Create Job Post' }}</h2>

    <form method="POST"
          action="{{ isset($jobPost) ? route('recruiter.job-posts.update', $jobPost) : route('recruiter.job-posts.store') }}"
          class="space-y-4">
        @csrf
        @if(isset($jobPost)) @method('PUT') @endif

        <div>
            <label class="block text-sm font-medium mb-1">Job Title</label>
            <input type="text" name="job_title" value="{{ old('job_title', $jobPost->job_title ?? '') }}"
                   class="w-full border rounded px-3 py-2 @error('job_title') border-red-500 @enderror">
            @error('job_title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Min Experience (yrs)</label>
                <input type="number" name="min_experience" min="0"
                       value="{{ old('min_experience', $jobPost->min_experience ?? '') }}"
                       class="w-full border rounded px-3 py-2 @error('min_experience') border-red-500 @enderror">
                @error('min_experience')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Max Experience (yrs)</label>
                <input type="number" name="max_experience" min="0"
                       value="{{ old('max_experience', $jobPost->max_experience ?? '') }}"
                       class="w-full border rounded px-3 py-2 @error('max_experience') border-red-500 @enderror">
                @error('max_experience')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Job Description</label>
            <textarea name="job_description" rows="5"
                      class="w-full border rounded px-3 py-2 @error('job_description') border-red-500 @enderror">{{ old('job_description', $jobPost->job_description ?? '') }}</textarea>
            @error('job_description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Skills Required</label>
            <div id="skills-container" class="space-y-2">
                @php $existingSkills = old('skills_required', $jobPost->skills_required ?? ['']); @endphp
                @foreach($existingSkills as $skill)
                <div class="flex gap-2">
                    <input type="text" name="skills_required[]" value="{{ $skill }}"
                           class="flex-1 border rounded px-3 py-2" placeholder="e.g. PHP">
                    <button type="button" onclick="this.parentElement.remove()"
                            class="bg-red-100 text-red-600 px-3 py-2 rounded text-sm">Remove</button>
                </div>
                @endforeach
            </div>
            <button type="button" onclick="addSkill()"
                    class="mt-2 text-sm text-indigo-600 hover:underline">+ Add Skill</button>
            @error('skills_required')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Location</label>
                <select name="location_id" class="w-full border rounded px-3 py-2 @error('location_id') border-red-500 @enderror">
                    <option value="">Select City</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc->id }}"
                            {{ old('location_id', $jobPost->location_id ?? '') == $loc->id ? 'selected' : '' }}>
                            {{ $loc->city }}
                        </option>
                    @endforeach
                </select>
                @error('location_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    @foreach(['active', 'inactive'] as $s)
                        <option value="{{ $s }}"
                            {{ old('status', $jobPost->status ?? 'active') === $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                {{ isset($jobPost) ? 'Update' : 'Create' }}
            </button>
            <a href="{{ route('recruiter.job-posts') }}" class="px-6 py-2 rounded border hover:bg-gray-50">Cancel</a>
        </div>
    </form>
</div>

<script>
function addSkill() {
    const container = document.getElementById('skills-container');
    const div = document.createElement('div');
    div.className = 'flex gap-2';
    div.innerHTML = `<input type="text" name="skills_required[]" placeholder="e.g. Laravel"
                            class="flex-1 border rounded px-3 py-2">
                     <button type="button" onclick="this.parentElement.remove()"
                             class="bg-red-100 text-red-600 px-3 py-2 rounded text-sm">Remove</button>`;
    container.appendChild(div);
}
</script>
@endsection
