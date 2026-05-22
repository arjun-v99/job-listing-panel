<?php

namespace App\Mail;

use App\Models\JobApplication;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\Queueable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;

class JobApplicationMail extends Mailable
{
    use SerializesModels;

    public function __construct(public JobApplication $application) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Job Application: ' . $this->application->jobPost->job_title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.job-application',
        );
    }
}
