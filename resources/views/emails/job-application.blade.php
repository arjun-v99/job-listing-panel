<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Job Application</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; padding: 20px;">
    <h2>New Application Received</h2>
    <p>A candidate has applied for <strong>{{ $application->jobPost->job_title }}</strong>.</p>

    <table style="border-collapse: collapse; width: 100%; max-width: 500px;">
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Candidate Name</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $application->jobSeeker->user->name }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Email</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $application->jobSeeker->user->email }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Phone</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $application->jobSeeker->phone }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Experience</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $application->jobSeeker->experience }} year(s)</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Notice Period</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $application->jobSeeker->notice_period }} day(s)</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Skills</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $application->jobSeeker->skills_string }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Location</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $application->jobSeeker->location->city }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Applied At</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $application->applied_at->format('d M Y, h:i A') }}</td>
        </tr>
    </table>

    <p style="margin-top: 20px;">
        <a href="{{ Storage::url($application->jobSeeker->resume) }}"
           style="background: #4f46e5; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 4px;">
            Download Resume
        </a>
    </p>

    <p style="color: #888; font-size: 12px; margin-top: 30px;">
        This is an automated notification from Job Listing Panel.
    </p>
</body>
</html>
