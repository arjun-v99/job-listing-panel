<?php

namespace App\Jobs;

use App\Mail\JobApplicationMail;
use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendApplicationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(public JobApplication $application) {}

    public function handle(): void
    {
        $recruiterEmail = $this->application->jobPost->recruiter->user->email;

        Mail::to($recruiterEmail)->send(new JobApplicationMail($this->application));
    }
}
