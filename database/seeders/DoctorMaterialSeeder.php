<?php

namespace Database\Seeders;

use App\Models\DoctorMaterial;
use Illuminate\Database\Seeder;

class DoctorMaterialSeeder extends Seeder
{
    const NAME_FILE = 'accreditation document';
    const PATH_FILE = 'default/article.png';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $doctors = [1, 2];

        foreach ($doctors as $id) {
            DoctorMaterial::create([
                'doctor_id' => $id,
                'name' => self::NAME_FILE,
                'material_path' => self::PATH_FILE,
            ]);
        }
    }
}
