<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Sales;
use App\Models\Product;
use App\Models\Variant;
use App\Http\Resources\SalesResource;
use App\Http\Requests\SalesRequest;
use App\Http\Requests\SalesUpdateRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;

function objectToArray(object $obj): array
{
    return Arr::dot($obj);
}

function arrayToString(array $arr): string
{
    return implode($arr);
}

function insertIntoArray(array $array, string $key, string $value): array
{
    return Arr::add($array, $key, $value);
}

function getFirstObjectOfArrayCollection(Collection $collection): object
{
    return $collection[0];
}

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        $sales = Sales::all();

        return response([
            'success' => true,
            'message' => 'Sales fethced.',
            'data' => SalesResource::collection($sales),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalesRequest $request): Response
    {
        $data = $request->validated();
        $lastInvoiceId = Invoice::latest()->pluck('id');
        $lastInvoiceId = arrayToString(objectToArray($lastInvoiceId));
        $sales = collect();

        foreach ($data as $sale) {
            $sale = insertIntoArray($sale, 'invoice_id', $lastInvoiceId);

            if (isset($sale['variant_id'])) {
                $product = $this->getProductWithVariantById($sale['product_id'], $sale['variant_id']);
                $variant = getFirstObjectOfArrayCollection($product->variant);

                $sale['price'] = $variant->price;
                $sale['total'] = $sale['price'] * $sale['qty'];

                $sales->push(Sales::create($sale));

                continue;
            }

            $product = $this->getProductById($sale['product_id']);

            $sale['price'] = $product->price;
            $sale['total'] = $sale['price'] * $sale['qty'];
            
            $sales->push(Sales::create($sale));
        }

        return response([
            'success' => true,
            'message' => 'Sales created.',
            'data' => $sales,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function show(Sales $sale): Response
    {
        return response([
            'success' => true,
            'message' => 'Sales fetched.',
            'data' => new SalesResource($sale),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function update(SalesUpdateRequest $request, Sales $sale): Response
    {
        $data = $request->validated();
        $sale->update($data);

        return response([
            'success' => true,
            'message' => 'Sales updated',
            'data' => new SalesResource($sale),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sales $sale): Response
    {
        $sale->delete();

        return response([
            'success' => true,
            'message' => 'Sales deleted.',
        ], 200);
    }

    public static function getProductById(int $id): Product
    {
        return Product::find($id);
    }

    public static function getProductWithVariantById(int $productId, int $variantId): Product
    {
        return Product::where('id', $productId)->with('variant', function ($query) use ($variantId) {
            $query->where('id', $variantId);
        })->first();
    }

}
