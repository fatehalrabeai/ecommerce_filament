<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $country = Country::create([
           'name' => "اليمن"
        ]);

        $cities = [
            [
                'country_id' => $country->id,
                'ar_name' => 'أمانة العاصمة',
                'en_name' => 'Amant Al-Asmah',
                'ar_slug' => 'أمانة-العاصمة',
                'en_slug' => 'Amant-Al-Asmah'
            ],
            [
                'country_id' => $country->id,
                'ar_name' => 'صنعاء',
                'en_name' => 'Sanaa',
                'ar_slug' => 'صنعاء',
                'en_slug' => 'Sanaa'
            ],
            [
                'country_id' => $country->id,
                'ar_name' => 'عدن',
                'en_name' => 'Aden',
                'ar_slug' => 'عدن',
                'en_slug' => 'Aden'
            ],
            [
                'country_id' => $country->id,
                'ar_name' => 'الحديدة',
                'en_name' => 'Al-Hodeidah',
                'ar_slug' => 'الحديدة',
                'en_slug' => 'Al-Hodeidah'
            ],
            [
                'country_id' => $country->id,
                'ar_name' => 'ذمار',
                'en_name' => 'Thamar',
                'ar_slug' => 'ذمار',
                'en_slug' => 'Thamar'
            ],
            [
                'country_id' => $country->id,
                'ar_name' => 'عمران',
                'en_name' => 'Amran',
                'ar_slug' => 'عمران',
                'en_slug' => 'Amran'
            ],
            [
                'country_id' => $country->id,
                'ar_name' => 'حجة',
                'en_name' => 'Hajjah',
                'ar_slug' => 'حجة',
                'en_slug' => 'Hajjah'
            ],
            [
                'country_id' => $country->id,
                'ar_name' => 'إب',
                'en_name' => 'Ibb',
                'ar_slug' => 'إب',
                'en_slug' => 'Ibb'
            ],
            [
                'country_id' => $country->id,
                'ar_name' => 'صعدة',
                'en_name' => 'Sa\'dah',
                'ar_slug' => 'صعدة',
                'en_slug' => 'Sadah'
            ],
            [
                'country_id' => $country->id,
                'ar_name' => 'البيضاء',
                'en_name' => 'Al-Baidha',
                'ar_slug' => 'البيضاء',
                'en_slug' => 'Al-Baidha'
            ],
            [
                'country_id' => $country->id,
                'ar_name' => 'شبوة',
                'en_name' => 'Shabwah',
                'ar_slug' => 'شبوة',
                'en_slug' => 'Shabwah'
            ],
            [
                'country_id' => $country->id,
                'ar_name' => 'تعز',
                'en_name' => 'Taiz',
                'ar_slug' => 'تعز',
                'en_slug' => 'Taiz'
            ],
            [
                'country_id' => $country->id,
                'ar_name' => 'الجوف',
                'en_name' => 'Al-jawf',
                'ar_slug' => 'الجوف',
                'en_slug' => 'Al-jawf'
            ],
            [
                'country_id' => $country->id,
                'ar_name' => 'مأرب',
                'en_name' => 'Ma\'rib',
                'ar_slug' => 'مأرب',
                'en_slug' => 'Marib'
            ],
            [
                'country_id' => $country->id,
                'ar_name' => 'حضرموت',
                'en_name' => 'Hadramot',
                'ar_slug' => 'حضرموت',
                'en_slug' => 'Hadramot'
            ],
            [
                'country_id' => $country->id,
                'ar_name' => 'المهرة',
                'en_name' => 'Al-Maharah',
                'ar_slug' => 'المهرة',
                'en_slug' => 'Al-Maharah'
            ],
            [
                'country_id' => $country->id,
                'ar_name' => 'الضالع',
                'en_name' => 'Al-Dhale\'',
                'ar_slug' => 'الضالع',
                'en_slug' => 'Al-Dhale'
            ],
            [
                'country_id' => $country->id,
                'ar_name' => 'المحويت',
                'en_name' => 'Al-Mahweet',
                'ar_slug' => 'المحويت',
                'en_slug' => 'Al-Mahweet'
            ],
            [
                'country_id' => $country->id,
                'ar_name' => 'لحج',
                'en_name' => 'Lahj',
                'ar_slug' => 'لحج',
                'en_slug' => 'Lahj'
            ],
            [
                'country_id' => $country->id,
                'ar_name' => 'ريمة',
                'en_name' => 'Raimah',
                'ar_slug' => 'ريمة',
                'en_slug' => 'Raimah'
            ],
            [
                'country_id' => $country->id,
                'ar_name' => 'سقطرى',
                'en_name' => 'Socatra',
                'ar_slug' => 'سقطرى',
                'en_slug' => 'Socatra'
            ],
            [
                'country_id' => $country->id,
                'ar_name' => 'أبين',
                'en_name' => 'Abyan',
                'ar_slug' => 'أبين',
                'en_slug' => 'Abyan'
            ]
        ];

        foreach ($cities as $city) {
            extract($city);
            \App\Models\City::create([
                'ar_name' => $ar_name,
                'en_name' => $en_name,
                'ar_slug' => $ar_slug,
                'en_slug' => $en_slug,
                'country_id' => $country_id,
            ]);
        }
    }
}
