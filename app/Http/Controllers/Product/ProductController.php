<?php

namespace App\Http\Controllers\Product;

use App\Http\Resources\Product\ProductWithInfoResource;
use App\Http\Resources\ProductSearchResource;
use App\Models\ProductInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function info(Request $request)
    {
        $product = $request->get('search') ?? '';
        $products = ProductInfo::where('name', 'like', '%' . $product . '%')->limit(30)->get();

        return response()->json(ProductSearchResource::collection($products));
    }

    public function fullInfo($id)
    {
        $product = ProductInfo::where('id', $id)->with(['mean', 'containing'])->firstOrFail();

        return response()->json(new ProductWithInfoResource($product));
    }
}
