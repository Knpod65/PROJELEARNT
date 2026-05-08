<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_subject_records', function (Blueprint $table) {
            $table->id();
            $table->string('record_code')->unique();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('department')->nullable();
            $table->enum('data_category', ['personal', 'financial', 'health', 'employment', 'other'])->default('personal');
            $table->string('collection_purpose')->nullable();
            $table->enum('lawful_basis', ['consent', 'contract', 'legal_obligation', 'vital_interests', 'public_task', 'legitimate_interests'])->default('consent');
            $table->enum('consent_status', ['given', 'withdrawn', 'pending'])->default('pending');
            $table->date('retention_until')->nullable();
            $table->enum('status', ['active', 'archived', 'pending_deletion'])->default('active');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index('record_code');
            $table->index('email');
            $table->index('consent_status');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_subject_records');
    }
};
