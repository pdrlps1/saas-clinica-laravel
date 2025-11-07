<?php

namespace App\Enums;

enum AppointmentStatus: string
{
    case Scheduled = 'scheduled';
    case Done = 'done';
    case Canceled = 'canceled';

    public function label(): string
    {
        return match($this) {
            self::Scheduled => 'Agendada',
            self::Done => 'Concluída',
            self::Canceled => 'Cancelada',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Scheduled => 'warning',  // Amarelo
            self::Done => 'success',       // Verde
            self::Canceled => 'danger',    // Vermelho
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::Scheduled => 'fa-clock',
            self::Done => 'fa-check-circle',
            self::Canceled => 'fa-times-circle',
        };
    }

    public function isEditable(): bool
    {
        return $this === self::Scheduled;
    }

    public function isCancelable(): bool
    {
        return $this === self::Scheduled;
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
