<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Variant;
use App\Http\Resources\VariantResource;
use App\Http\Requests\VariantRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class VariantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($product): Response
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
     * @param  \Illuminate\Http\Requests\VariantRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VariantRequest $request): Response
    {
        $data = $request->validated();
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
    public function show(Product $product, Variant $variant): Response
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
    public function update(Request $request, Product $product, Variant $variant): Response
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
    public function destroy(Product $product, Variant $variant): Response
    {
        $variant->delete();

        return response([
            'success' => true,
            'message' => 'Variant deleted.',
        ], 200);
    }
}
