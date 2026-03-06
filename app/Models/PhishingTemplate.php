<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhishingTemplate extends Model
{
    protected $fillable = [
        'organization_id', 'name', 'category', 'difficulty',
        'sender_name', 'sender_email', 'subject', 'body_html',
        'body_text', 'landing_page', 'is_global', 'tags', 'use_count',
    ];

    protected $casts = [
        'is_global' => 'boolean',
        'tags' => 'array',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }

    /**
     * Replace template variables with actual employee data.
     */
    public function renderSubject(Employee $employee): string
    {
        return $this->replaceVars($this->subject, $employee);
    }

    public function renderBody(Employee $employee, string $trackingUrl, string $pixelUrl): string
    {
        $html = $this->replaceVars($this->body_html, $employee);
        // Inject tracking pixel
        $pixel = '<img src="' . $pixelUrl . '" width="1" height="1" style="display:none" />';
        // Replace click links
        $html = preg_replace(
            '/href="(https?:\/\/[^"]+)"/i',
            'href="' . $trackingUrl . '"',
            $html,
            1
        );
        return $html . $pixel;
    }

    private function replaceVars(string $text, Employee $employee): string
    {
        return str_replace([
            '{{first_name}}', '{{last_name}}', '{{full_name}}',
            '{{email}}', '{{department}}', '{{position}}',
        ], [
            $employee->first_name, $employee->last_name, $employee->full_name,
            $employee->email, $employee->department ?? '', $employee->position ?? '',
        ], $text);
    }
}
