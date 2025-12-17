<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'title',
        'report_type',
        'period_start',
        'period_end',
        'total_consultations',
        'total_users',
        'total_psikologs',
        'statistics',
        'summary',
        'status',
        'sent_at',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'statistics' => 'array',
        'sent_at' => 'datetime',
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Helper methods
    public function getReportTypeNameAttribute()
    {
        return match($this->report_type) {
            'monthly' => 'Bulanan',
            'quarterly' => 'Triwulan',
            'annual' => 'Tahunan',
            default => $this->report_type,
        };
    }

    public function isSent()
    {
        return $this->status === 'sent';
    }
}
