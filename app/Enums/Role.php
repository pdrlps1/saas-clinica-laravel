<?php

namespace App;

enum Role: string
{
    case Owner = 'owner';
    case Staff = 'staff';

    public function label(): string
    {
        return match($this){
            self::Owner => 'Proprietário',
            self::Staff => 'Equipe',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Owner => 'primary',
            self::Staff => 'secondary'
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}