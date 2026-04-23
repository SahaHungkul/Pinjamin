<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PaginatedResource;
use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetCategoryRequest $request)
    {
        $categories = Category::search($request->search)->latest()->paginate($request->limit ?? 10);

        return ApiResponse::success(
            new PaginatedResource($categories, CategoryResource::class),
            'Categories List'
        );
    }

    public function option(GetCategoryRequest $request){
        $categories = Category::select('id','nama_kategori')->search($request->search)->orderBy('nama_kategori')->get();

        return ApiResponse::success(
            CategoryResource::collection($categories),
            'Categories List'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return ApiResponse::success(
            new CategoryResource($category),
            'Category created successfully',
            Response::HTTP_CREATED,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        if(!$category){
            return ApiResponse::error(
                'Category not found',
                Response::HTTP_NOT_FOUND,
            );
        }

        return ApiResponse::success(
            new CategoryResource($category),
            'Category Details'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $category = Category::find($id);

        if(!$category){
            return ApiResponse::error(
                'Category not found',
                Response::HTTP_NOT_FOUND,
            );
        }

        $category->update($request->validated());

        return ApiResponse::success(
            new CategoryResource($category),
            'Category Update Successfully',
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        if(!$category){
            return ApiResponse::error(
                'Category not found',
                Response::HTTP_NOT_FOUND,
            );
        }

        if($category->image){
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return ApiResponse::success(
            null,
            'Category Deleted Successfully'
        );
    }
}
