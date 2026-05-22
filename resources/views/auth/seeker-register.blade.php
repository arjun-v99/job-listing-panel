@extends('layouts.app')
@section('title', 'Job Seeker Registration')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Register as Job Seeker</h2>

    <form method="POST" action="{{ route('register.seeker.post') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
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
                <label class="block text-sm font-medium mb-1">Experience (Years)</label>
                <input type="number" name="experience" value="{{ old('experience') }}" min="0"
                       class="w-full border rounded px-3 py-2 @error('experience') border-red-500 @enderror">
                @error('experience')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Notice Period (Days)</label>
                <input type="number" name="notice_period" value="{{ old('notice_period') }}" min="0"
                       class="w-full border rounded px-3 py-2 @error('notice_period') border-red-500 @enderror">
                @error('notice_period')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Job Location</label>
                <select name="location_id" class="w-full border rounded px-3 py-2 @error('location_id') border-red-500 @enderror">
                    <option value="">Select City</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc->id }}" {{ old('location_id') == $loc->id ? 'selected' : '' }}>
                            {{ $loc->city }}
                        </option>
                    @endforeach
                </select>
                @error('location_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Skills <span class="text-gray-400 text-xs">(add one per line)</span></label>
            <div id="skills-container" class="space-y-2">
                <div class="flex gap-2">
                    <input type="text" name="skills[]" placeholder="e.g. PHP"
                           class="flex-1 border rounded px-3 py-2">
                    <button type="button" onclick="addSkill()"
                            class="bg-indigo-100 text-indigo-700 px-3 py-2 rounded text-sm">+ Add</button>
                </div>
            </div>
            @error('skills')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Resume (PDF/DOC)</label>
                <input type="file" name="resume" accept=".pdf,.doc,.docx"
                       class="w-full border rounded px-3 py-2 @error('resume') border-red-500 @enderror">
                @error('resume')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Photo (JPG/PNG)</label>
                <input type="file" name="photo" accept=".jpg,.jpeg,.png"
                       class="w-full border rounded px-3 py-2 @error('photo') border-red-500 @enderror">
                @error('photo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
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

        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 mt-2">Register</button>
        <p class="text-center text-sm">Already have an account? <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Login</a></p>
    </form>
</div>

<script>
function addSkill() {
    const container = document.getElementById('skills-container');
    const div = document.createElement('div');
    div.className = 'flex gap-2';
    div.innerHTML = `<input type="text" name="skills[]" placeholder="e.g. Laravel"
                            class="flex-1 border rounded px-3 py-2">
                     <button type="button" onclick="this.parentElement.remove()"
                             class="bg-red-100 text-red-600 px-3 py-2 rounded text-sm">Remove</button>`;
    container.appendChild(div);
}
</script>
@endsection
