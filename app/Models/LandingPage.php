<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LandingPage extends Model
{
    protected $fillable = [
        'organization_id', 'name', 'slug', 'html',
        'capture_credentials', 'is_global',
    ];

    protected $casts = [
        'capture_credentials' => 'boolean',
        'is_global' => 'boolean',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
