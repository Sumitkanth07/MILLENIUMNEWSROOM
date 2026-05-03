<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    protected $fillable = [
        'company_name',
        'email',
        'phone',
        'address',
        'copyright_text',
    ];

    public static function current(): self
    {
        return static::firstOrCreate([], [
            'company_name' => 'Navurja Renewable Energy Solutions',
            'email' => 'info@navurja.com',
            'phone' => '+91 9876543210',
            'address' => 'New Delhi, India',
            'copyright_text' => '(c) '.date('Y').' Navurja Renewable Energy Solutions. All rights reserved.',
        ]);
    }
}
