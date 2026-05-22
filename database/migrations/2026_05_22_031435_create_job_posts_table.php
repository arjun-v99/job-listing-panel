<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recruiter_id')->constrained()->cascadeOnDelete();
            $table->string('job_title');
            $table->unsignedTinyInteger('min_experience');
            $table->unsignedTinyInteger('max_experience');
            $table->text('job_description');
            $table->json('skills_required');
            $table->foreignId('location_id')->constrained();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
