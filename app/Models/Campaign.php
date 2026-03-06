<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    protected $fillable = [
        'organization_id', 'created_by', 'phishing_template_id', 'landing_page_id',
        'name', 'description', 'status', 'scheduled_at', 'started_at', 'completed_at',
        'sending_profile', 'send_delay_seconds', 'track_opens', 'track_clicks',
        'capture_credentials',
    ];

    protected $casts = [
        'scheduled_at'       => 'datetime',
        'started_at'         => 'datetime',
        'completed_at'       => 'datetime',
        'track_opens'        => 'boolean',
        'track_clicks'       => 'boolean',
        'capture_credentials' => 'boolean',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(PhishingTemplate::class, 'phishing_template_id');
    }

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }

    public function targets(): HasMany
    {
        return $this->hasMany(CampaignTarget::class);
    }

    // ── Stats ────────────────────────────────────────────────────────────────

    public function getStatsAttribute(): array
    {
        $targets = $this->targets;
        $total   = $targets->count();

        if ($total === 0) {
            return ['total' => 0, 'sent' => 0, 'opened' => 0, 'clicked' => 0, 'submitted' => 0, 'reported' => 0];
        }

        return [
            'total'     => $total,
            'sent'      => $targets->whereNotNull('sent_at')->count(),
            'opened'    => $targets->whereNotNull('opened_at')->count(),
            'clicked'   => $targets->whereNotNull('clicked_at')->count(),
            'submitted' => $targets->whereNotNull('submitted_at')->count(),
            'reported'  => $targets->whereNotNull('reported_at')->count(),
            'open_rate'    => round($targets->whereNotNull('opened_at')->count() / $total * 100, 1),
            'click_rate'   => round($targets->whereNotNull('clicked_at')->count() / $total * 100, 1),
            'submit_rate'  => round($targets->whereNotNull('submitted_at')->count() / $total * 100, 1),
        ];
    }

    public function isEditable(): bool
    {
        return in_array($this->status, ['draft', 'scheduled']);
    }
}
