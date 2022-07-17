<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Response;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @returIc wawancara unactiveUndangann \Illuminate\Http\Response
     */
    public function index(): Response
    {
        $categories = Category::all();

        return response([
            'success' => true,
            'message' => 'Categories Fetched.',
            'data' => CategoryResource::collection($categories),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request): Response
    {
        $data = $request->validated();
        $category = Category::create($data);

        return response([
            'success' => true,
            'message' => 'Category created succesfully.',
            'data' => $category,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category): Response
    {
        return response([
            'success' => true,
            'message' => 'Category fetched.',
            'data' => new CategoryResource($category),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category): Response
    {
        $data = $request->validated();
        $category->update($data);
        
        return response([
            'success' => true,
            'message' => 'Category updated.',
            'data' => new CategoryResource($category),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category): Response
    {
        $category->delete();

        return response([
            'success' => true,
            'message' => 'Category deleted.'
        ]);
    }
}
