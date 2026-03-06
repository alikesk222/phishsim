<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class CampaignTarget extends Model
{
    protected $fillable = [
        'campaign_id', 'employee_id', 'token', 'status',
        'sent_at', 'opened_at', 'clicked_at', 'submitted_at', 'reported_at',
        'ip_address', 'user_agent', 'submitted_data',
    ];

    protected $casts = [
        'sent_at'      => 'datetime',
        'opened_at'    => 'datetime',
        'clicked_at'   => 'datetime',
        'submitted_at' => 'datetime',
        'reported_at'  => 'datetime',
        'submitted_data' => 'array',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->token)) {
                $model->token = Str::random(48);
            }
        });
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function markOpened(string $ip, string $ua): void
    {
        if ($this->opened_at === null) {
            $this->update(['opened_at' => now(), 'status' => 'opened', 'ip_address' => $ip, 'user_agent' => $ua]);
        }
    }

    public function markClicked(string $ip, string $ua): void
    {
        $this->markOpened($ip, $ua);
        if ($this->clicked_at === null) {
            $this->update(['clicked_at' => now(), 'status' => 'clicked', 'ip_address' => $ip, 'user_agent' => $ua]);
            $this->employee->increment('phished_count');
            $this->employee->recalculateRiskLevel();
        }
    }

    public function markSubmitted(string $ip, string $ua, array $data = []): void
    {
        $this->markClicked($ip, $ua);
        if ($this->submitted_at === null) {
            // Never store real credentials — only field names as evidence
            $safeData = array_map(fn($v) => !empty($v) ? '[CAPTURED]' : '[EMPTY]', $data);
            $this->update(['submitted_at' => now(), 'status' => 'submitted', 'submitted_data' => $safeData]);
        }
    }

    public function markReported(): void
    {
        $this->update(['reported_at' => now(), 'status' => 'reported']);
    }
}
