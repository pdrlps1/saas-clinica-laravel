<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    protected $fillable = [
        'organization_id',
        'name',
        'email',
        'phone',
        'birthdate'
    ];

    protected $casts = [
        'birthdate' => 'date',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function appointment(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function getAge(): ?int
    {
        return $this->birthdate?->age;
    }

    public function getDisplayName(): string
    {
        return $this->name . ($this->email ? "({$this->email})" : '');
    }
}
