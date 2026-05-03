<?php

namespace Database\Seeders;

use App\Models\Blog;
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
        $admin = User::updateOrCreate(
            ['email' => 'admin@navurja.test'],
            ['name' => 'Navurja Admin', 'password' => Hash::make('password'), 'is_admin' => true]
        );

        FooterSetting::updateOrCreate(
            ['id' => 1],
            [
                'company_name' => 'Navurja Renewable Energy Solutions',
                'email' => 'info@navurja.com',
                'phone' => '+91 9876543210',
                'address' => 'New Delhi, India',
                'copyright_text' => '© '.date('Y').' Navurja. All rights reserved.',
            ]
        );

        Blog::updateOrCreate(
            ['slug' => 'benefits-of-solar-panels'],
            [
                'user_id' => $admin->id,
                'title' => 'Renewable Energy, Clean Energy and solar solutions for Homes',
                'excerpt' => 'Learn how renewable energy, clean energy and solar solutions help homeowners reduce bills and support a sustainable future.',
                'content' => '<p>Renewable energy solutions are becoming an increasingly popular choice for homeowners looking to reduce electricity bills and environmental impact. Solar panels, wind power and efficient clean energy systems can provide dependable power while lowering monthly energy costs.</p><p>One of the major advantages of renewable energy is sustainability. Unlike fossil fuels, clean energy technologies reduce harmful emissions and support a healthier future. Solar solutions remain one of the most practical options for homes, while broader renewable technologies help communities build resilient power systems.</p><p>With advancements in technology, renewable systems have become more efficient and affordable. Many governments also offer incentives and subsidies, making it easier for homeowners to adopt sustainable energy. Overall, investing in renewable energy is a smart decision for both your wallet and the planet.</p>',
                'image' => 'uploads/solar-panels-placeholder.svg',
                'meta_title' => 'Renewable Energy, Clean Energy and solar solutions for Homes | Navurja',
                'meta_description' => 'Discover renewable energy solutions, clean energy benefits, solar solutions, sustainability and long-term savings for homes.',
                'is_published' => true,
                'published_at' => now(),
            ]
        );

        Service::whereIn('sort_order', [1, 2, 3, 4])->delete();

        foreach ([
            'site_name' => 'Navurja Renewable Energy Solutions',
            'site_title' => 'Navurja | Renewable Energy Solutions',
            'tagline' => 'Clean Energy for a Better Future',
            'primary_color' => '#1f8f45',
            'secondary_color' => '#f4b23b',
            'logo' => '',
            'meta_description' => 'Navurja delivers renewable energy solutions, clean energy systems, solar solutions, sustainable energy consulting and efficient power systems.',
        ] as $key => $value) {
            Setting::setValue($key, $value);
        }

        Project::where('location', 'Nashik')->where('capacity', '30 kW')->delete();

        foreach ([
            ['key' => 'hero', 'title' => 'Renewable Energy for a Better Future', 'subtitle' => 'Navurja Renewable Energy Solutions', 'content' => 'Power your home, business, or institution with solar, wind and clean energy systems designed for long-term savings.', 'button_text' => 'Calculate Energy Savings', 'button_url' => '/savings-calculator', 'sort_order' => 1],
            ['key' => 'about', 'title' => 'About Navurja', 'subtitle' => 'Reliable renewable energy partner', 'content' => 'We help customers adopt solar energy, renewable technologies and efficient power systems for a sustainable future.', 'sort_order' => 2],
            ['key' => 'services', 'title' => 'Renewable Energy Services', 'subtitle' => 'Everything needed for clean power', 'content' => 'From consulting to installation, Navurja manages practical renewable energy details so your clean energy journey is simple.', 'sort_order' => 3],
            ['key' => 'projects', 'title' => 'Recent Projects', 'subtitle' => 'Clean energy systems delivered with care', 'content' => 'A few examples of renewable energy systems delivered for homes, schools and commercial roofs.', 'sort_order' => 4],
            ['key' => 'contact', 'title' => 'Start Your Renewable Energy Journey', 'subtitle' => 'Talk to Navurja', 'content' => 'Share your energy goals, roof details and bill amount. Our team will help estimate the right clean energy solution.', 'button_text' => 'Email Us', 'button_url' => 'mailto:hello@navurja.test', 'sort_order' => 5],
        ] as $section) {
            HomepageSection::updateOrCreate(['key' => $section['key']], $section);
        }

        foreach ([
            ['title' => 'Solar Panel Installation', 'description' => 'Custom rooftop solar solutions for lower bills and dependable clean power.', 'icon' => 'home', 'sort_order' => 1],
            ['title' => 'Renewable Energy Consulting', 'description' => 'Practical guidance for solar, wind, storage and clean energy planning.', 'icon' => 'factory', 'sort_order' => 2],
            ['title' => 'Energy Efficiency Solutions', 'description' => 'Audits and improvements that reduce waste and improve power performance.', 'icon' => 'shield', 'sort_order' => 3],
            ['title' => 'Sustainable Power Systems', 'description' => 'Integrated renewable power systems for homes, institutions and businesses.', 'icon' => 'power', 'sort_order' => 4],
        ] as $service) {
            Service::updateOrCreate(['title' => $service['title']], $service);
        }

        foreach ([
            ['title' => 'Home Rooftop System', 'location' => 'Pune', 'capacity' => '5 kW', 'description' => 'A compact grid-tied system for a family home.', 'sort_order' => 1],
            ['title' => 'School Renewable Power System', 'location' => 'Nashik', 'capacity' => '30 kW', 'description' => 'Clean energy generation for classrooms and administration blocks.', 'sort_order' => 2],
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
