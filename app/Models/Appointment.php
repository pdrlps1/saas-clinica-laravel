<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'organization_id',
        'patient_id',
        'responsible_user_id',
        'starts_at',
        'duration_min',
        'status',
        'notes',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'status' => AppointmentStatus::class,
        'duration_min' => 'integer',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    public function isResponsible(User $user): bool
    {
        return $this->responsible_user_id === $user->id;
    }

    public function getEndsAt(): \Carbon\Carbon
    {
        return $this->starts_at->copy()->addMinutes($this->duration_min);
    }

    public function isPast(): bool
    {
        return $this->starts_at->isPast();
    }

    public function canBeCanceled(): bool
    {
        return $this->status->isCancelable() && !$this->isPast();
    }

    public function canBeCompleted(): bool
    {
        return $this->status === AppointmentStatus::Scheduled;
    }
}
