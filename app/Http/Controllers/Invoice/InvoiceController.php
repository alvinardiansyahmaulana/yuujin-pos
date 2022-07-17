<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Http\Resources\InvoiceResource;
use App\Http\Requests\InvoiceRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

function objectToArray(object $obj): array
{
    return Arr::dot($obj);
}

function arrayToString(array $arr): string
{
    return implode($arr);
}

function createInvoicePrefix(string $invoiceId): string
{
    return 'INV/'. date('d-m-Y').'/'. is_null($invoiceId) ? $invoiceId+1 : 1;
}

function insertInvoiceNumber(array $data, string $invoiceId): array
{
    return Arr::add($data, 'number', createInvoicePrefix($invoiceId));
}

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        $invoices = Invoice::all();

        return response([
            'success' => true,
            'message' => 'Invoices fetched.',
            'data' => InvoiceResource::collection($invoices),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceRequest $request): Response
    {
        $data = $request->validated();

        $lastInvoiceId = Invoice::latest()->pluck('id');
        $lastInvoiceId = arrayToString(objectToArray($lastInvoiceId));
        $data = insertInvoiceNumber($data, $lastInvoiceId);

        $invoice = Invoice::create($data);

        return response([
            'success' => true,
            'message' => 'Invoice created.',
            'data' => $invoice,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice): Response
    {
        return response([
            'success' => true,
            'message' => 'Invoice fetched.',
            'data' => new InvoiceResource($invoice),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(InvoiceRequest $request, Invoice $invoice): Response
    {
        $invoice->update($request->validated());

        return response([
            'success' => true,
            'message' => 'Invoice updated.',
            'data' => new InvoiceResource($invoice),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice): Response
    {
        $invoice->delete();

        return response([
            'success' => true,
            'message' => 'Invoice deleted.',
        ], 200);
    }
}
