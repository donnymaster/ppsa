<?php

namespace App\Http\Controllers\Product;

use App\Http\Requests\ProductInfo\CreateProductRequest;
use App\Models\ProductContaining;
use App\Models\ProductInfo;
use App\Models\ProductMean;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ProductInfoController extends Controller
{

    public function store(CreateProductRequest $request)
    {
        $validated = $request->validated();
        $doctor = Auth::user()->doctor;

        $productInfo = ProductInfo::firstOrCreate([
            'name' => $validated['name_product'],
            'doctor_id' => $doctor->id,
        ]);

        $productMean = collect($validated['mean_product'])->map(function ($item) {
            return ['name' => $item];
        });

        $productContained = collect($validated['contained_product'])->map(function ($item) {
            return ['name' => $item];
        });

        $productInfo->mean()->createMany($productMean);
        $productInfo->containing()->createMany($productContained);

        return redirect()->route('directory');
    }
}
