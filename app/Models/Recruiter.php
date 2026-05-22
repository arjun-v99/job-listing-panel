<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recruiter extends Model
{
    protected $fillable = ['user_id', 'company_name', 'phone', 'address'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobPosts(): HasMany
    {
        return $this->hasMany(JobPost::class);
    }

    public function activeJobPosts(): HasMany
    {
        return $this->hasMany(JobPost::class)->where('status', 'active');
    }
}
