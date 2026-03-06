<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    protected $fillable = [
        'name', 'slug', 'domain', 'logo', 'plan', 'employee_limit',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function employeeGroups(): HasMany
    {
        return $this->hasMany(EmployeeGroup::class);
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }

    public function phishingTemplates(): HasMany
    {
        return $this->hasMany(PhishingTemplate::class);
    }

    public function getEmployeeCountAttribute(): int
    {
        return $this->employees()->where('active', true)->count();
    }
}
