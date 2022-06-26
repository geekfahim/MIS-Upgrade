<?php

namespace Database\Seeders;

use App\Models\Base\Settings\Asset;
use Illuminate\Database\Seeder;

class AssetTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $item = ['Agro Land', 'House Land', 'Gold', 'Silver', 'Other Precious Jewelry', 'Cow/Buffalo', 'Goat/Sheep', 'Duck/Chicken/Pigeon/Birds', 'Plow/Axe', 'Spray Machine', 'Power Tiller/ thrasher machine/ Irrigation pump', 'SEWING MACHINE', 'Boat', 'Fishing Net', 'Tube Well', 'Computer/Television', 'Motor Cycle', 'CNG/Auto/EasyBike', 'Rikshaw/By Cycle/Van/Thela Gari', 'Furniture', 'Mobile/Smart Phone', 'Others'];
        $maxCount = count($item);
        for ($i = 0; $i < $maxCount; $i++) {
            $data[] = [
                'name' => $item[$i],
                'created_by' => 1,
                'created_at' => now(),
            ];
        }
        $chunks = array_chunk($data, $maxCount);
        foreach ($chunks as $chunk) {
            Asset::insert($chunk);
        }
    }
}
