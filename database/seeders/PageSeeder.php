<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Page;
use Faker\Factory as Faker;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $adminUser = \App\Models\User::first();
        if (!$adminUser) {
            $adminUser = \App\Models\User::create([
                'name'     => 'Super Admin',
                'email'    => 'super@gmail.com',
                'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
            ]);
        }
        $adminId = $adminUser->id;

        Page::updateOrCreate(
            ["slug" => Str::slug('About Us')],
            [
                'temp'              => 'default',
                'page_title'        => 'About Aire',
                'slug'              => Str::slug('About Us'),
                'breadcrumb'        => 'About Us',
                'short_des'         => 'Pioneering next-generation indoor air quality solutions and precision cleanroom filtration systems.',
                'page_description'  => '<p class="content-text mt-5">Aire is an innovative engineering leader dedicated to high-performance indoor air quality solutions, medical-grade HEPA purification, and commercial air ventilation systems. Founded with a vision to protect human health and enhance indoor environmental well-being, Aire combines aerosol physics, advanced IoT filtration sensors, and sustainable aerodynamic design.</p><p class="content-text mt-3">From residential living spaces and modern workspaces to critical healthcare laboratories and industrial cleanrooms, Aire delivers uncompromising air purity, silent efficiency, and intelligent air monitoring worldwide.</p>',
                'f_image'           => 'themes/default/assets/img/Air-Purify.png',
                'meta_title'        => 'About Aire | Clean Air Engineering & IAQ Solutions',
                'meta_description'  => 'Learn about Aire’s mission to deliver cutting-edge air purification systems, HEPA filtration, and smart clean air technologies.',
                'meta_keyword'      => 'About Aire, indoor air quality, cleanroom technology, HEPA filtration, smart air purifier',
                'status'            => 1,
<<<<<<< HEAD
                'createdBy'         => $adminId,
                'updatedBy'         => $adminId,
=======
                'createdBy'         => 1,
                'updatedBy'         => 1,
>>>>>>> 9d4263d40313bc3158e1cd219112a3ef620a211e
            ]
        );
        Page::updateOrCreate(
            ["slug" => Str::slug('Contact Us')],
            [
                'temp'              => 'default',
                'page_title'        => 'Contact Aire',
                'breadcrumb'        => 'Contact Us',
                'slug'              => Str::slug('Contact Us'),
                'short_des'         => 'Get in touch with our air quality specialists and technical support team.',
                'page_description'  => '<p class="content-text mt-5">Have inquiries regarding commercial HVAC retrofits, cleanroom filtration systems, or residential air purifiers? Our engineering and support team is here to assist you with tailored indoor air quality solutions.</p>',
                'f_image'           => 'themes/default/assets/img/Air-Purify.png',
                'meta_title'        => 'Contact Aire | Clean Air Specialists & Support',
                'meta_description'  => 'Reach out to the Aire support team for consultations, technical support, warranty inquiries, and enterprise solutions.',
                'meta_keyword'      => 'Contact Aire, clean air consultation, air purifier support, commercial filtration inquiries',
                'status'            => 1,
<<<<<<< HEAD
                'createdBy'         => $adminId,
                'updatedBy'         => $adminId,
=======
                'createdBy'         => 1,
                'updatedBy'         => 1,
>>>>>>> 9d4263d40313bc3158e1cd219112a3ef620a211e
            ]
        );
        Page::updateOrCreate(
            ["slug" => Str::slug('History')],
            [
                'temp'              => 'default',
                'page_title'        => 'Our Heritage & History',
                'breadcrumb'        => 'History',
                'slug'              => Str::slug('History'),
                'short_des'         => 'A decade of precision aerosol engineering and groundbreaking air purification milestones.',
                'page_description'  => '<p class="content-text mt-5">Aire began as a specialized aerosol filtration research lab in 2015, striving to engineer particulate filtration systems capable of capturing sub-micron pathogens without heavy energy draw. Over the past decade, Aire has deployed thousands of clean air systems across hospitals, cleanrooms, enterprise offices, and modern households around the world.</p>',
                'f_image'           => 'themes/default/assets/img/Air-Purify.png',
                'meta_title'        => 'History & Milestones | Aire Indoor Air Quality',
                'meta_description'  => 'Explore Aire’s journey from an aerosol research laboratory to an international leader in clean air solutions.',
                'meta_keyword'      => 'Aire history, air purification innovations, clean air engineering milestones',
                'status'            => 1,
<<<<<<< HEAD
                'createdBy'         => $adminId,
                'updatedBy'         => $adminId,
=======
                'createdBy'         => 1,
                'updatedBy'         => 1,
>>>>>>> 9d4263d40313bc3158e1cd219112a3ef620a211e
            ]
        );
        Page::updateOrCreate(
            ["slug" => Str::slug('Technology')],
            [
                'temp'              => 'default',
                'page_title'        => 'Filtration Technology',
                'breadcrumb'        => 'Technology',
                'slug'              => Str::slug('Technology'),
                'short_des'         => 'Discover our proprietary multi-stage H13 HEPA, activated carbon, and UV-C purification architectures.',
                'page_description'  => '<p class="content-text mt-5">Aire systems incorporate multi-layer medical-grade H13 HEPA media, high-density activated carbon pellets for VOC absorption, and photocatalytic UV-C sterilization chambers designed to eliminate 99.97% of airborne pathogens down to 0.1 microns.</p>',
                'f_image'           => 'themes/default/assets/img/Air-Purify.png',
                'meta_title'        => 'Filtration Technology & Innovation | Aire',
                'meta_description'  => 'Discover Aire’s cutting-edge H13 HEPA filtration and smart indoor air quality sensing technologies.',
                'meta_keyword'      => 'HEPA technology, air purifier filtration, VOC reduction, clean air engineering',
                'status'            => 1,
<<<<<<< HEAD
                'createdBy'         => $adminId,
                'updatedBy'         => $adminId,
=======
                'createdBy'         => 1,
                'updatedBy'         => 1,
>>>>>>> 9d4263d40313bc3158e1cd219112a3ef620a211e
            ]
        );
    }
}
