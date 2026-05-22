<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\SeekerController;
use Illuminate\Support\Facades\Route;

// ── Guest Routes ───────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/',                     fn() => redirect()->route('login'));
    Route::get('/login',                [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',               [AuthController::class, 'login'])->name('login.post');

    Route::get('/register/seeker',      [AuthController::class, 'showSeekerRegister'])->name('register.seeker');
    Route::post('/register/seeker',     [AuthController::class, 'registerSeeker'])->name('register.seeker.post');

    Route::get('/register/recruiter',   [AuthController::class, 'showRecruiterRegister'])->name('register.recruiter');
    Route::post('/register/recruiter',  [AuthController::class, 'registerRecruiter'])->name('register.recruiter.post');
});

// ── Shared Auth ────────────────────────────────────────────────────────────
Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Recruiter Routes ───────────────────────────────────────────────────────
Route::middleware(['auth', 'role:recruiter'])->prefix('recruiter')->name('recruiter.')->group(function () {
    Route::get('/dashboard',                        [RecruiterController::class, 'dashboard'])->name('dashboard');

    // Job Posts CRUD
    Route::get('/job-posts',                        [RecruiterController::class, 'jobPosts'])->name('job-posts');
    Route::get('/job-posts/create',                 [RecruiterController::class, 'createJobPost'])->name('job-posts.create');
    Route::post('/job-posts',                       [RecruiterController::class, 'storeJobPost'])->name('job-posts.store');
    Route::get('/job-posts/{jobPost}/edit',         [RecruiterController::class, 'editJobPost'])->name('job-posts.edit');
    Route::put('/job-posts/{jobPost}',              [RecruiterController::class, 'updateJobPost'])->name('job-posts.update');
    Route::delete('/job-posts/{jobPost}',           [RecruiterController::class, 'destroyJobPost'])->name('job-posts.destroy');

    // Candidate tools
    Route::get('/find-candidates',                  [RecruiterController::class, 'findCandidates'])->name('find-candidates');
    Route::get('/applied-jobs',                     [RecruiterController::class, 'appliedJobs'])->name('applied-jobs');
});

// ── Seeker Routes ──────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:seeker'])->prefix('seeker')->name('seeker.')->group(function () {
    Route::get('/dashboard',            [SeekerController::class, 'dashboard'])->name('dashboard');
    Route::get('/find-jobs',            [SeekerController::class, 'findJobs'])->name('find-jobs');
    Route::post('/apply/{jobPost}',     [SeekerController::class, 'applyJob'])->name('apply');
    Route::get('/my-applications',      [SeekerController::class, 'myApplications'])->name('my-applications');
});
