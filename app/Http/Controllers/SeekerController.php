<?php

namespace App\Http\Controllers;

use App\Jobs\SendApplicationEmail;
use App\Models\JobApplication;
use App\Models\JobPost;
use App\Models\Location;
use App\Models\Recruiter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeekerController extends Controller
{
    public function dashboard(): View
    {
        $seeker = auth()->user()->seeker;
        $stats = [
            'applied_count' => $seeker->appliedJobs()->count(),
        ];
        return view('seeker.dashboard', compact('stats'));
    }

    // ── Find Jobs ──────────────────────────────────────────────────────────

    public function findJobs(Request $request): View
    {
        $locations  = Location::orderBy('city')->get();
        $companies  = Recruiter::orderBy('company_name')->get();

        $query = JobPost::active()->with(['recruiter', 'location']);

        if ($request->filled('skills')) {
            $skills = array_map('trim', explode(',', $request->skills));
            $query->withSkills($skills);
        }

        if ($request->filled('company_id')) {
            $query->where('recruiter_id', $request->company_id);
        }

        if ($request->filled('min_experience')) {
            $query->where('min_experience', '>=', $request->min_experience);
        }

        if ($request->filled('max_experience')) {
            $query->where('max_experience', '<=', $request->max_experience);
        }

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        $jobs = $query->latest()->paginate(15)->withQueryString();

        // Mark already-applied jobs for this seeker
        $appliedIds = auth()->user()->seeker
            ->appliedJobs()
            ->pluck('job_posts.id')
            ->toArray();

        return view('seeker.find-jobs', compact('jobs', 'locations', 'companies', 'appliedIds'));
    }

    // ── Apply for Job ──────────────────────────────────────────────────────

    public function applyJob(JobPost $jobPost): RedirectResponse
    {
        $seeker = auth()->user()->seeker;

        // Prevent duplicate application
        $alreadyApplied = JobApplication::where('job_post_id', $jobPost->id)
            ->where('job_seeker_id', $seeker->id)
            ->exists();

        if ($alreadyApplied) {
            return back()->with('error', 'You have already applied for this job.');
        }

        abort_if(!$jobPost->isActive(), 403, 'This job is no longer active.');

        $application = JobApplication::create([
            'job_post_id'   => $jobPost->id,
            'job_seeker_id' => $seeker->id,
            'applied_at'    => now(),
        ]);

        // Dispatch queued mail to recruiter
        SendApplicationEmail::dispatch($application);

        return back()->with('success', 'Application submitted! Recruiter has been notified.');
    }

    // ── Applied Jobs (seeker view) ─────────────────────────────────────────

    public function myApplications(): View
    {
        $applications = auth()->user()->seeker
            ->appliedJobs()
            ->with(['recruiter', 'location'])
            ->withPivot('applied_at')
            ->latest('job_applications.created_at')
            ->paginate(15);

        return view('seeker.my-applications', compact('applications'));
    }
}
