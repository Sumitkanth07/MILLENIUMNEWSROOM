<?php

namespace Database\Seeders;

use App\Models\CalculatorSetting;
use App\Models\City;
use App\Models\FooterSetting;
use App\Models\HomepageSection;
use App\Models\NavigationItem;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@navurja.test'],
            ['name' => 'Navurja Admin', 'password' => Hash::make('password'), 'is_admin' => true]
        );

        FooterSetting::updateOrCreate(
            ['id' => 1],
            [
                'company_name' => 'Navurja',
                'email' => 'info@navurja.com',
                'phone' => '+91 9876543210',
                'address' => 'New Delhi, India',
                'copyright_text' => '© '.date('Y').' Navurja. All rights reserved.',
            ]
        );

        foreach ([
            'site_name' => 'Navurja',
            'site_title' => 'Navurja | Solar Energy Solutions',
            'tagline' => 'Clean Energy for a Better Future',
            'primary_color' => '#1f8f45',
            'secondary_color' => '#f4b23b',
            'logo' => '',
            'meta_description' => 'Navurja delivers solar energy systems, EPC support, rooftop installations and clean-energy guidance for homes and businesses.',
        ] as $key => $value) {
            Setting::setValue($key, $value);
        }

        foreach ([
            ['key' => 'hero', 'title' => 'Clean Energy for a Better Future', 'subtitle' => 'Navurja Solar Energy Solutions', 'content' => 'Power your home, business, or institution with dependable solar systems designed for long-term savings.', 'button_text' => 'Calculate Savings', 'button_url' => '/savings-calculator', 'sort_order' => 1],
            ['key' => 'about', 'title' => 'About Navurja', 'subtitle' => 'Reliable solar partner', 'content' => 'We help customers move to renewable energy with site surveys, design, installation, maintenance and honest savings guidance.', 'sort_order' => 2],
            ['key' => 'services', 'title' => 'Solar Services', 'subtitle' => 'Everything needed to go solar', 'content' => 'From consultation to commissioning, Navurja manages the practical details so your solar journey is simple.', 'sort_order' => 3],
            ['key' => 'projects', 'title' => 'Recent Projects', 'subtitle' => 'Installed with care', 'content' => 'A few examples of clean-energy systems delivered for homes, schools and commercial roofs.', 'sort_order' => 4],
            ['key' => 'contact', 'title' => 'Start Your Solar Journey', 'subtitle' => 'Talk to Navurja', 'content' => 'Share your roof details and bill amount. Our team will help estimate the right system size.', 'button_text' => 'Email Us', 'button_url' => 'mailto:hello@navurja.test', 'sort_order' => 5],
        ] as $section) {
            HomepageSection::updateOrCreate(['key' => $section['key']], $section);
        }

        foreach ([
            ['title' => 'Residential Rooftop Solar', 'description' => 'Custom rooftop systems for lower bills and dependable daytime power.', 'icon' => 'home', 'sort_order' => 1],
            ['title' => 'Commercial Solar EPC', 'description' => 'Design, procurement and installation for businesses seeking measurable energy savings.', 'icon' => 'factory', 'sort_order' => 2],
            ['title' => 'Solar Maintenance', 'description' => 'Performance checks, panel cleaning plans and system health support.', 'icon' => 'shield', 'sort_order' => 3],
        ] as $service) {
            Service::updateOrCreate(['title' => $service['title']], $service);
        }

        foreach ([
            ['title' => 'Home Rooftop System', 'location' => 'Pune', 'capacity' => '5 kW', 'description' => 'A compact grid-tied system for a family home.', 'sort_order' => 1],
            ['title' => 'School Solar Plant', 'location' => 'Nashik', 'capacity' => '30 kW', 'description' => 'Solar generation for classrooms and administration blocks.', 'sort_order' => 2],
            ['title' => 'Commercial Rooftop', 'location' => 'Mumbai', 'capacity' => '75 kW', 'description' => 'Energy savings for daily business operations.', 'sort_order' => 3],
        ] as $project) {
            Project::updateOrCreate(['title' => $project['title']], $project);
        }

        foreach ([
            ['label' => 'Home', 'url' => '/#home', 'sort_order' => 1],
            ['label' => 'About', 'url' => '/#about', 'sort_order' => 2],
            ['label' => 'Services', 'url' => '/#services', 'sort_order' => 3],
            ['label' => 'Projects', 'url' => '/#projects', 'sort_order' => 4],
            ['label' => 'Blog', 'url' => '/blog', 'sort_order' => 5],
            ['label' => 'Calculator', 'url' => '/savings-calculator', 'sort_order' => 6],
            ['label' => 'Contact', 'url' => '/#contact', 'sort_order' => 7],
        ] as $item) {
            NavigationItem::updateOrCreate(['label' => $item['label']], $item);
        }

        CalculatorSetting::firstOrCreate([], ['electricity_rate' => 8, 'sun_hours' => 4.5, 'co2_factor' => 1.35]);

        foreach ([['Mumbai', 1.05], ['Pune', 1.02], ['Nashik', 1], ['Nagpur', 1.12], ['Delhi', 1.06], ['Bengaluru', .95]] as [$name, $multiplier]) {
            City::updateOrCreate(['name' => $name], ['multiplier' => $multiplier, 'is_active' => true]);
        }
    }
}
