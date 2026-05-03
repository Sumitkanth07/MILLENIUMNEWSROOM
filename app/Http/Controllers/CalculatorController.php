<?php

namespace App\Http\Controllers;

use App\Models\CalculatorSetting;
use App\Models\City;

class CalculatorController extends Controller
{
    public function show()
    {
        return view('calculator.show', [
            'setting' => CalculatorSetting::firstOrCreate([], ['electricity_rate' => 8, 'sun_hours' => 4.5, 'co2_factor' => 1.35]),
            'cities' => City::where('is_active', true)->orderBy('name')->get(),
            'metaTitle' => 'Energy Savings Calculator | Navurja',
            'metaDescription' => 'Estimate clean energy savings with a solar calculator, one of Navurja renewable energy solutions.',
        ]);
    }
}
