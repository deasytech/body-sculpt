<?php

namespace App\Enums;

enum StaffType: string
{
    case Instructor = 'instructor';
    case Therapist = 'therapist';
    case FrontDesk = 'front_desk';
    case Manager = 'manager';
    case Admin = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::Instructor => 'Instructor',
            self::Therapist => 'Therapist',
            self::FrontDesk => 'Front Desk',
            self::Manager => 'Manager',
            self::Admin => 'Admin',
        };
    }
}
