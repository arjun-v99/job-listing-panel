<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JobPost extends Model
{
    protected $fillable = [
        'recruiter_id',
        'job_title',
        'min_experience',
        'max_experience',
        'job_description',
        'skills_required',
        'location_id',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'skills_required' => 'array',
        ];
    }

    public function recruiter(): BelongsTo
    {
        return $this->belongsTo(Recruiter::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function applicants(): BelongsToMany
    {
        return $this->belongsToMany(JobSeeker::class, 'job_applications')
            ->withPivot('applied_at')
            ->withTimestamps();
    }

    // Scope: active jobs only
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    // Scope: filter by skills (JSON overlap)
    public function scopeWithSkills(Builder $query, array $skills): Builder
    {
        return $query->where(function ($q) use ($skills) {
            foreach ($skills as $skill) {
                $q->orWhereJsonContains('skills_required', $skill);
            }
        });
    }

    // Helper: skills as comma string
    public function getSkillsStringAttribute(): string
    {
        return implode(', ', $this->skills_required ?? []);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
