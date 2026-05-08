<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSubjectRequest extends Model
{
    /** @use HasFactory<\Database\Factories\DataSubjectRequestFactory> */
    use HasFactory;

    protected $fillable = [
        'data_subject_record_id',
        'request_type',
        'status',
        'request_details',
        'response_details',
        'request_date',
        'deadline_date',
        'completed_date',
        'rejection_reason',
        'assigned_to',
        'created_by',
    ];

    protected $casts = [
        'request_date' => 'date',
        'deadline_date' => 'date',
        'completed_date' => 'date',
    ];

    public function dataSubjectRecord()
    {
        return $this->belongsTo(DataSubjectRecord::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeOverdue($query)
    {
        return $query->whereDate('deadline_date', '<', now()->toDateString())
                     ->whereIn('status', ['pending', 'in_progress']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function isOverdue(): bool
    {
        return now()->greaterThan($this->deadline_date) && !in_array($this->status, ['completed', 'rejected']);
    }
}
