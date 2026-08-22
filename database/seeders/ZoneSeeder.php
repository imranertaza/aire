<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zone;

class ZoneSeeder extends Seeder
{
    public function run(): void
    {
        $zones = [
            // Bangladesh (country_id = 18)
            ['country_id' => 18, 'name' => 'Dhaka', 'code' => 'DHA', 'status' => 1],
            ['country_id' => 18, 'name' => 'Chittagong', 'code' => 'CTG', 'status' => 1],
            ['country_id' => 18, 'name' => 'Sylhet', 'code' => 'SYL', 'status' => 1],
            ['country_id' => 18, 'name' => 'Rajshahi', 'code' => 'RAJ', 'status' => 1],
            ['country_id' => 18, 'name' => 'Khulna', 'code' => 'KHU', 'status' => 1],
            ['country_id' => 18, 'name' => 'Barisal', 'code' => 'BAR', 'status' => 1],
            ['country_id' => 18, 'name' => 'Rangpur', 'code' => 'RAN', 'status' => 1],
            ['country_id' => 18, 'name' => 'Mymensingh', 'code' => 'MYM', 'status' => 1],
            ['country_id' => 18, 'name' => 'Comilla', 'code' => 'COM', 'status' => 1],
            ['country_id' => 18, 'name' => 'Gazipur', 'code' => 'GAZ', 'status' => 1],
            ['country_id' => 18, 'name' => 'Narayanganj', 'code' => 'NAR', 'status' => 1],
            ['country_id' => 18, 'name' => 'Cox\'s Bazar', 'code' => 'CXB', 'status' => 1],
            ['country_id' => 18, 'name' => 'Bogra', 'code' => 'BOG', 'status' => 1],
            ['country_id' => 18, 'name' => 'Jessore', 'code' => 'JES', 'status' => 1],
            ['country_id' => 18, 'name' => 'Noakhali', 'code' => 'NOA', 'status' => 1],

            // United States (country_id = 223)
            ['country_id' => 223, 'name' => 'Alabama', 'code' => 'AL', 'status' => 1],
            ['country_id' => 223, 'name' => 'Alaska', 'code' => 'AK', 'status' => 1],
            ['country_id' => 223, 'name' => 'Arizona', 'code' => 'AZ', 'status' => 1],
            ['country_id' => 223, 'name' => 'Arkansas', 'code' => 'AR', 'status' => 1],
            ['country_id' => 223, 'name' => 'California', 'code' => 'CA', 'status' => 1],
            ['country_id' => 223, 'name' => 'Colorado', 'code' => 'CO', 'status' => 1],
            ['country_id' => 223, 'name' => 'Connecticut', 'code' => 'CT', 'status' => 1],
            ['country_id' => 223, 'name' => 'Delaware', 'code' => 'DE', 'status' => 1],
            ['country_id' => 223, 'name' => 'Florida', 'code' => 'FL', 'status' => 1],
            ['country_id' => 223, 'name' => 'Georgia', 'code' => 'GA', 'status' => 1],
            ['country_id' => 223, 'name' => 'Hawaii', 'code' => 'HI', 'status' => 1],
            ['country_id' => 223, 'name' => 'Idaho', 'code' => 'ID', 'status' => 1],
            ['country_id' => 223, 'name' => 'Illinois', 'code' => 'IL', 'status' => 1],
            ['country_id' => 223, 'name' => 'Indiana', 'code' => 'IN', 'status' => 1],
            ['country_id' => 223, 'name' => 'Iowa', 'code' => 'IA', 'status' => 1],
            ['country_id' => 223, 'name' => 'Kansas', 'code' => 'KS', 'status' => 1],
            ['country_id' => 223, 'name' => 'Kentucky', 'code' => 'KY', 'status' => 1],
            ['country_id' => 223, 'name' => 'Louisiana', 'code' => 'LA', 'status' => 1],
            ['country_id' => 223, 'name' => 'Maine', 'code' => 'ME', 'status' => 1],
            ['country_id' => 223, 'name' => 'Maryland', 'code' => 'MD', 'status' => 1],
            ['country_id' => 223, 'name' => 'Massachusetts', 'code' => 'MA', 'status' => 1],
            ['country_id' => 223, 'name' => 'Michigan', 'code' => 'MI', 'status' => 1],
            ['country_id' => 223, 'name' => 'Minnesota', 'code' => 'MN', 'status' => 1],
            ['country_id' => 223, 'name' => 'Mississippi', 'code' => 'MS', 'status' => 1],
            ['country_id' => 223, 'name' => 'Missouri', 'code' => 'MO', 'status' => 1],
            ['country_id' => 223, 'name' => 'Montana', 'code' => 'MT', 'status' => 1],
            ['country_id' => 223, 'name' => 'Nebraska', 'code' => 'NE', 'status' => 1],
            ['country_id' => 223, 'name' => 'Nevada', 'code' => 'NV', 'status' => 1],
            ['country_id' => 223, 'name' => 'New Hampshire', 'code' => 'NH', 'status' => 1],
            ['country_id' => 223, 'name' => 'New Jersey', 'code' => 'NJ', 'status' => 1],
            ['country_id' => 223, 'name' => 'New Mexico', 'code' => 'NM', 'status' => 1],
            ['country_id' => 223, 'name' => 'New York', 'code' => 'NY', 'status' => 1],
            ['country_id' => 223, 'name' => 'North Carolina', 'code' => 'NC', 'status' => 1],
            ['country_id' => 223, 'name' => 'North Dakota', 'code' => 'ND', 'status' => 1],
            ['country_id' => 223, 'name' => 'Ohio', 'code' => 'OH', 'status' => 1],
            ['country_id' => 223, 'name' => 'Oklahoma', 'code' => 'OK', 'status' => 1],
            ['country_id' => 223, 'name' => 'Oregon', 'code' => 'OR', 'status' => 1],
            ['country_id' => 223, 'name' => 'Pennsylvania', 'code' => 'PA', 'status' => 1],
            ['country_id' => 223, 'name' => 'Rhode Island', 'code' => 'RI', 'status' => 1],
            ['country_id' => 223, 'name' => 'South Carolina', 'code' => 'SC', 'status' => 1],
            ['country_id' => 223, 'name' => 'South Dakota', 'code' => 'SD', 'status' => 1],
            ['country_id' => 223, 'name' => 'Tennessee', 'code' => 'TN', 'status' => 1],
            ['country_id' => 223, 'name' => 'Texas', 'code' => 'TX', 'status' => 1],
            ['country_id' => 223, 'name' => 'Utah', 'code' => 'UT', 'status' => 1],
            ['country_id' => 223, 'name' => 'Vermont', 'code' => 'VT', 'status' => 1],
            ['country_id' => 223, 'name' => 'Virginia', 'code' => 'VA', 'status' => 1],
            ['country_id' => 223, 'name' => 'Washington', 'code' => 'WA', 'status' => 1],
            ['country_id' => 223, 'name' => 'West Virginia', 'code' => 'WV', 'status' => 1],
            ['country_id' => 223, 'name' => 'Wisconsin', 'code' => 'WI', 'status' => 1],
            ['country_id' => 223, 'name' => 'Wyoming', 'code' => 'WY', 'status' => 1],

            // United Kingdom (country_id = 222)
            ['country_id' => 222, 'name' => 'Greater London', 'code' => 'LON', 'status' => 1],
            ['country_id' => 222, 'name' => 'Greater Manchester', 'code' => 'MAN', 'status' => 1],
            ['country_id' => 222, 'name' => 'West Midlands', 'code' => 'WMD', 'status' => 1],
            ['country_id' => 222, 'name' => 'West Yorkshire', 'code' => 'WYK', 'status' => 1],
            ['country_id' => 222, 'name' => 'Scotland', 'code' => 'SCT', 'status' => 1],
            ['country_id' => 222, 'name' => 'Wales', 'code' => 'WLS', 'status' => 1],
            ['country_id' => 222, 'name' => 'Northern Ireland', 'code' => 'NIR', 'status' => 1],

            // United Arab Emirates (country_id = 221)
            ['country_id' => 221, 'name' => 'Abu Dhabi', 'code' => 'AZ', 'status' => 1],
            ['country_id' => 221, 'name' => 'Dubai', 'code' => 'DU', 'status' => 1],
            ['country_id' => 221, 'name' => 'Sharjah', 'code' => 'SH', 'status' => 1],
            ['country_id' => 221, 'name' => 'Ajman', 'code' => 'AJ', 'status' => 1],
            ['country_id' => 221, 'name' => 'Fujairah', 'code' => 'FU', 'status' => 1],
            ['country_id' => 221, 'name' => 'Ras Al Khaimah', 'code' => 'RK', 'status' => 1],
            ['country_id' => 221, 'name' => 'Umm Al Quwain', 'code' => 'UQ', 'status' => 1],

            // Canada (country_id = 38)
            ['country_id' => 38, 'name' => 'Ontario', 'code' => 'ON', 'status' => 1],
            ['country_id' => 38, 'name' => 'Quebec', 'code' => 'QC', 'status' => 1],
            ['country_id' => 38, 'name' => 'British Columbia', 'code' => 'BC', 'status' => 1],
            ['country_id' => 38, 'name' => 'Alberta', 'code' => 'AB', 'status' => 1],
            ['country_id' => 38, 'name' => 'Manitoba', 'code' => 'MB', 'status' => 1],
            ['country_id' => 38, 'name' => 'Saskatchewan', 'code' => 'SK', 'status' => 1],

            // Australia (country_id = 13)
            ['country_id' => 13, 'name' => 'New South Wales', 'code' => 'NSW', 'status' => 1],
            ['country_id' => 13, 'name' => 'Victoria', 'code' => 'VIC', 'status' => 1],
            ['country_id' => 13, 'name' => 'Queensland', 'code' => 'QLD', 'status' => 1],
            ['country_id' => 13, 'name' => 'Western Australia', 'code' => 'WA', 'status' => 1],
            ['country_id' => 13, 'name' => 'South Australia', 'code' => 'SA', 'status' => 1],
            ['country_id' => 13, 'name' => 'Tasmania', 'code' => 'TAS', 'status' => 1],
        ];

        foreach ($zones as $z) {
            Zone::updateOrCreate(
                ['country_id' => $z['country_id'], 'name' => $z['name']],
                $z
            );
        }
    }
}
