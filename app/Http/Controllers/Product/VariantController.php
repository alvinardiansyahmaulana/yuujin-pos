<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Variant;
use App\Http\Resources\VariantResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VariantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($product)
    {
        $variants = Variant::where('product_id', $product)->get();

        return response([
            'success' => true,
            'message' => 'Product variant fetched.',
            'data' => VariantResource::collection($variants),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make(['product' => $data], [
            'product.*.name' => 'required|max:255',
            'product.*.price' => 'required',
            'product.*.product_id' => 'required'
        ], [
            'product.*.required' => 'The :attribute field is required.'
        ]);

        if ($validator->fails()) {
            return response([
                'success' => 'false',
                'message' => $validator->errors()
            ], 400);
        }

        $variants = collect();

        foreach ($data as $variant) {
            $variants->push(Variant::create($variant));
        }


        return response([
            'success' => true,
            'message' => 'Variant created.',
            'data' => $variants,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, Variant $variant)
    {
        return response([
            'success' => true,
            'message' => 'Variant fetched.',
            'data' => new VariantResource($variant),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, Variant $variant)
    {
        $variant->update($request->all());

        return response([
            'success' => true,
            'message' => 'Variant updated.',
            'data' => new VariantResource($variant),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Variant $variant)
    {
        $variant->delete();

        return response([
            'success' => true,
            'message' => 'Variant deleted.',
        ], 200);
    }
}
