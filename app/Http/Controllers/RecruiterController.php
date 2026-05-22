<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobPostRequest;
use App\Models\JobPost;
use App\Models\JobSeeker;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecruiterController extends Controller
{
    // ── Dashboard ─────────────────────────────────────────────────────────

    public function dashboard(): View
    {
        $recruiter = auth()->user()->recruiter;
        $stats = [
            'total_posts'    => $recruiter->jobPosts()->count(),
            'active_posts'   => $recruiter->activeJobPosts()->count(),
            'total_applied'  => $recruiter->jobPosts()->withCount('applicants')->get()->sum('applicants_count'),
        ];
        return view('recruiter.dashboard', compact('stats'));
    }

    // ── Job Post CRUD ──────────────────────────────────────────────────────

    public function jobPosts(): View
    {
        $posts = auth()->user()->recruiter
            ->jobPosts()
            ->with('location')
            ->latest()
            ->paginate(10);

        return view('recruiter.job-posts.index', compact('posts'));
    }

    public function createJobPost(): View
    {
        $locations = Location::orderBy('city')->get();
        return view('recruiter.job-posts.create', compact('locations'));
    }

    public function storeJobPost(JobPostRequest $request): RedirectResponse
    {
        auth()->user()->recruiter->jobPosts()->create($request->validated());

        return redirect()->route('recruiter.job-posts')->with('success', 'Job post created.');
    }

    public function editJobPost(JobPost $jobPost): View
    {
        abort_if($jobPost->recruiter_id !== auth()->user()->recruiter->id, 403);

        $locations = Location::orderBy('city')->get();
        return view('recruiter.job-posts.edit', compact('jobPost', 'locations'));
    }

    public function updateJobPost(JobPostRequest $request, JobPost $jobPost): RedirectResponse
    {
        abort_if($jobPost->recruiter_id !== auth()->user()->recruiter->id, 403);

        $jobPost->update($request->validated());

        return redirect()->route('recruiter.job-posts')->with('success', 'Job post updated.');
    }

    public function destroyJobPost(JobPost $jobPost): RedirectResponse
    {
        abort_if($jobPost->recruiter_id !== auth()->user()->recruiter->id, 403);

        $jobPost->delete();

        return redirect()->route('recruiter.job-posts')->with('success', 'Job post deleted.');
    }

    // ── Find Candidates ────────────────────────────────────────────────────

    public function findCandidates(Request $request): View
    {
        $locations = Location::orderBy('city')->get();

        $query = JobSeeker::with(['user', 'location']);

        if ($request->filled('skills')) {
            $skills = array_map('trim', explode(',', $request->skills));
            $query->where(function ($q) use ($skills) {
                foreach ($skills as $skill) {
                    $q->orWhereJsonContains('skills', $skill);
                }
            });
        }

        if ($request->filled('notice_period')) {
            $query->where('notice_period', '<=', $request->notice_period);
        }

        if ($request->filled('min_experience')) {
            $query->where('experience', '>=', $request->min_experience);
        }

        if ($request->filled('max_experience')) {
            $query->where('experience', '<=', $request->max_experience);
        }

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        $candidates = $query->paginate(15)->withQueryString();

        return view('recruiter.find-candidates', compact('candidates', 'locations'));
    }

    // ── Applied Jobs ───────────────────────────────────────────────────────

    public function appliedJobs(Request $request): View
    {
        $recruiter = auth()->user()->recruiter;

        $applications = \App\Models\JobApplication::with([
            'jobPost',
            'jobSeeker.user',
            'jobSeeker.location',
        ])
            ->whereHas('jobPost', fn($q) => $q->where('recruiter_id', $recruiter->id))
            ->latest()
            ->paginate(15);

        return view('recruiter.applied-jobs', compact('applications'));
    }
}
