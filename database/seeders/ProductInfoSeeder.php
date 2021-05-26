<?php

namespace Database\Seeders;

use App\Models\ProductContaining;
use App\Models\ProductInfo;
use App\Models\ProductMean;
use Illuminate\Database\Seeder;
use function Database\Seeders\ProductInformation\getProductsInformation;

class ProductInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        foreach (getProductsInformation() as $key => $product) {
            $createdProduct = ProductInfo::create([
                'doctor_id' => 1,
                'name' => $key,
            ]);

            foreach ($product['mean'] as $mean) {
                ProductMean::create([
                    'product_info_id' => $createdProduct->id,
                    'name' => $mean,
                ]);
            }

            foreach ($product['contains'] as $containInProduct) {
                ProductContaining::create([
                    'product_info_id' => $createdProduct->id,
                    'name' => $containInProduct,
                ]);
            }
        }
    }
}
