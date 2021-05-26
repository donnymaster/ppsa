<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;
use function Database\Seeders\ProductInformation\getUnits;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (getUnits() as $unit) {
            Unit::create([
                'name' => $unit['name'],
                'short_name' => $unit['short_name']
            ]);
        }
    }
}
