<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class JobSeeker extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'experience',
        'notice_period',
        'skills',
        'location_id',
        'resume',
        'photo',
    ];

    protected function casts(): array
    {
        return [
            'skills' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function appliedJobs(): BelongsToMany
    {
        return $this->belongsToMany(JobPost::class, 'job_applications')
            ->withPivot('applied_at')
            ->withTimestamps();
    }

    // Helper: full resume URL
    public function getResumeUrlAttribute(): string
    {
        return Storage::url($this->resume);
    }

    // Helper: full photo URL
    public function getPhotoUrlAttribute(): string
    {
        return Storage::url($this->photo);
    }

    // Helper: skills as comma string
    public function getSkillsStringAttribute(): string
    {
        return implode(', ', $this->skills ?? []);
    }
}
