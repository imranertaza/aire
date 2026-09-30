<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            ['id' => 1, 'name' => 'Afghanistan', 'iso_code_2' => 'AF', 'iso_code_3' => 'AFG', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 2, 'name' => 'Albania', 'iso_code_2' => 'AL', 'iso_code_3' => 'ALB', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 3, 'name' => 'Algeria', 'iso_code_2' => 'DZ', 'iso_code_3' => 'DZA', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 4, 'name' => 'American Samoa', 'iso_code_2' => 'AS', 'iso_code_3' => 'ASM', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 5, 'name' => 'Andorra', 'iso_code_2' => 'AD', 'iso_code_3' => 'AND', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 6, 'name' => 'Angola', 'iso_code_2' => 'AO', 'iso_code_3' => 'AGO', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 7, 'name' => 'Anguilla', 'iso_code_2' => 'AI', 'iso_code_3' => 'AIA', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 8, 'name' => 'Antarctica', 'iso_code_2' => 'AQ', 'iso_code_3' => 'ATA', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 9, 'name' => 'Antigua and Barbuda', 'iso_code_2' => 'AG', 'iso_code_3' => 'ATG', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 10, 'name' => 'Argentina', 'iso_code_2' => 'AR', 'iso_code_3' => 'ARG', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 11, 'name' => 'Armenia', 'iso_code_2' => 'AM', 'iso_code_3' => 'ARM', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 12, 'name' => 'Aruba', 'iso_code_2' => 'AW', 'iso_code_3' => 'ABW', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 13, 'name' => 'Australia', 'iso_code_2' => 'AU', 'iso_code_3' => 'AUS', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 14, 'name' => 'Austria', 'iso_code_2' => 'AT', 'iso_code_3' => 'AUT', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 15, 'name' => 'Azerbaijan', 'iso_code_2' => 'AZ', 'iso_code_3' => 'AZE', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 16, 'name' => 'Bahamas', 'iso_code_2' => 'BS', 'iso_code_3' => 'BHS', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 17, 'name' => 'Bahrain', 'iso_code_2' => 'BH', 'iso_code_3' => 'BHR', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 18, 'name' => 'Bangladesh', 'iso_code_2' => 'BD', 'iso_code_3' => 'BGD', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 19, 'name' => 'Barbados', 'iso_code_2' => 'BB', 'iso_code_3' => 'BRB', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 20, 'name' => 'Belarus', 'iso_code_2' => 'BY', 'iso_code_3' => 'BLR', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 21, 'name' => 'Belgium', 'iso_code_2' => 'BE', 'iso_code_3' => 'BEL', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 22, 'name' => 'Belize', 'iso_code_2' => 'BZ', 'iso_code_3' => 'BLZ', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 23, 'name' => 'Benin', 'iso_code_2' => 'BJ', 'iso_code_3' => 'BEN', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 24, 'name' => 'Bermuda', 'iso_code_2' => 'BM', 'iso_code_3' => 'BMU', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 25, 'name' => 'Bhutan', 'iso_code_2' => 'BT', 'iso_code_3' => 'BTN', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 26, 'name' => 'Bolivia', 'iso_code_2' => 'BO', 'iso_code_3' => 'BOL', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 27, 'name' => 'Bosnia and Herzegovina', 'iso_code_2' => 'BA', 'iso_code_3' => 'BIH', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 28, 'name' => 'Botswana', 'iso_code_2' => 'BW', 'iso_code_3' => 'BWA', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 29, 'name' => 'Bouvet Island', 'iso_code_2' => 'BV', 'iso_code_3' => 'BVT', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 30, 'name' => 'Brazil', 'iso_code_2' => 'BR', 'iso_code_3' => 'BRA', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 38, 'name' => 'Canada', 'iso_code_2' => 'CA', 'iso_code_3' => 'CAN', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 44, 'name' => 'China', 'iso_code_2' => 'CN', 'iso_code_3' => 'CHN', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 63, 'name' => 'Egypt', 'iso_code_2' => 'EG', 'iso_code_3' => 'EGY', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 74, 'name' => 'France', 'iso_code_2' => 'FR', 'iso_code_3' => 'FRA', 'address_format' => '', 'postcode_required' => 1, 'status' => 1],
            ['id' => 81, 'name' => 'Germany', 'iso_code_2' => 'DE', 'iso_code_3' => 'DEU', 'address_format' => '', 'postcode_required' => 1, 'status' => 1],
            ['id' => 99, 'name' => 'India', 'iso_code_2' => 'IN', 'iso_code_3' => 'IND', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 105, 'name' => 'Italy', 'iso_code_2' => 'IT', 'iso_code_3' => 'ITA', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 107, 'name' => 'Japan', 'iso_code_2' => 'JP', 'iso_code_3' => 'JPN', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 129, 'name' => 'Malaysia', 'iso_code_2' => 'MY', 'iso_code_3' => 'MYS', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 162, 'name' => 'Pakistan', 'iso_code_2' => 'PK', 'iso_code_3' => 'PAK', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 184, 'name' => 'Saudi Arabia', 'iso_code_2' => 'SA', 'iso_code_3' => 'SAU', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 188, 'name' => 'Singapore', 'iso_code_2' => 'SG', 'iso_code_3' => 'SGP', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 221, 'name' => 'United Arab Emirates', 'iso_code_2' => 'AE', 'iso_code_3' => 'ARE', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
            ['id' => 222, 'name' => 'United Kingdom', 'iso_code_2' => 'GB', 'iso_code_3' => 'GBR', 'address_format' => '', 'postcode_required' => 1, 'status' => 1],
            ['id' => 223, 'name' => 'United States', 'iso_code_2' => 'US', 'iso_code_3' => 'USA', 'address_format' => '', 'postcode_required' => 0, 'status' => 1],
        ];

        foreach ($countries as $c) {
            Country::updateOrCreate(['id' => $c['id']], $c);
        }
    }
}
