<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'organization_id', 'first_name', 'last_name', 'email',
        'department', 'position', 'risk_level', 'phished_count',
        'trained_count', 'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(EmployeeGroup::class, 'employee_group_pivot');
    }

    public function campaignTargets(): HasMany
    {
        return $this->hasMany(CampaignTarget::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function recalculateRiskLevel(): void
    {
        $this->risk_level = match (true) {
            $this->phished_count >= 4 => 'critical',
            $this->phished_count >= 2 => 'high',
            $this->phished_count >= 1 => 'medium',
            default => 'low',
        };
        $this->save();
    }
}
