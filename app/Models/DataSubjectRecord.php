<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSubjectRecord extends Model
{
    /** @use HasFactory<\Database\Factories\DataSubjectRecordFactory> */
    use HasFactory;

    protected $fillable = [
        'record_code',
        'full_name',
        'email',
        'phone',
        'department',
        'data_category',
        'collection_purpose',
        'lawful_basis',
        'consent_status',
        'retention_until',
        'status',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'retention_until' => 'date',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function requests()
    {
        return $this->hasMany(DataSubjectRequest::class);
    }

    public function auditLogs()
    {
        return $this->morphMany(AuditLog::class, 'model');
    }

    public function scopeActive($query)
    {
        return $query->where('consent_status', '!=', 'withdrawn');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('data_category', $category);
    }

    public function scopeRetentionExpiringSoon($query, $days = 30)
    {
        return $query->whereNotNull('retention_until')
                     ->whereDate('retention_until', '<=', now()->addDays($days)->toDateString())
                     ->whereDate('retention_until', '>', now()->toDateString())
                     ->where('status', 'active');
    }
}
