<?php

namespace App\Enums;

enum CategoryStatus
{
    const Active = 'active';
    const Inactive = 'inactive';

    // Add additional methods if needed
    const value = "";

    public static function getLabel(): string
    {
        return match (self::value) {
            self::Active => __('Active'),
            self::Inactive => __('Inactive'),
            default => __('Unknown Status'),
        };
    }

    public static function getIcon(): string
    {
        return match (self::value) {
            self::Active => 'heroicon-o-check-circle', // Example icon
            self::Inactive => 'heroicon-o-x-circle',   // Example icon
            default => 'heroicon-o-question-mark',
        };
    }

    public static function getColor(): string
    {
        return match (self::value) {
            self::Active => 'success', // Example color
            self::Inactive => 'danger', // Example color
            default => 'gray',
        };
    }
}
