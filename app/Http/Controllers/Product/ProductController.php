<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Constant\ValidatorMessage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        $products = Product::all();

        return response([
            'success' => true,
            'message' => 'All product fetched.',
            'data' => ProductResource::collection($products),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request): Response
    {
        $data = $request->validated();
        $product = Product::create($data);

        return response([
            'success' => true,
            'message' => 'Product created.',
            'data' => $product,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product): Response
    {
        return response([
            'success' => true,
            'message' => 'Product fetched.',
            'data' => new ProductResource($product),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product): Response
    {
        $data = $request->validated();
        $product->update($data);

        return response([
            'success' => true,
            'message' => 'Product updated',
            'data' => new ProductResource($product),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product): Response
    {
        $product->delete();

        return response([
            'success' => true,
            'message' => 'Product deleted.'
        ], 200);
    }
}
