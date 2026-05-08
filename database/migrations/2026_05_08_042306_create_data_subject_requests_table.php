<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_subject_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_subject_record_id')->constrained('data_subject_records')->cascadeOnDelete();
            $table->enum('request_type', ['access', 'deletion', 'rectification', 'portability', 'restrict_processing', 'object_processing'])->default('access');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'rejected', 'withdrawn'])->default('pending');
            $table->text('request_details')->nullable();
            $table->text('response_details')->nullable();
            $table->date('request_date')->nullable();
            $table->date('deadline_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->index('request_type');
            $table->index('status');
            $table->index('deadline_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_subject_requests');
    }
};
