<?php

namespace Database\Seeders;

use App\Models\Base\Settings\Income;
use Illuminate\Database\Seeder;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $item = ['Agricultural goods sale', 'Duck, Hen, Pigeon, Birds or Egg sale', 'Cattle sale (Cow, Buffalo, Goat, Sheep or Milk, Dung sale)', 'Fish Hunting /Cultivation and sale', 'Handicraft Business', 'Fruits sale', 'Income from Rent or ledge', 'Income from savings', 'Any govt Allowance (Relief /VGF/VGD)', 'Other NGO Aid/Help (Relief)', 'Donation/Aid', 'Begging', 'Income from Tuition', 'Income from scholarship', 'Income from shop/small business', 'Income from Rakshasa/ Van/Auto Rickshaw, CNG', 'Regular Income from any relatives', 'Other with name'];
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
            Income::insert($chunk);
        }
    }
}
