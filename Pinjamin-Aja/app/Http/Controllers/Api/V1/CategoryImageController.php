<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadCategoryImageRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

// use Illuminate\Http\Request;

class CategoryImageController extends Controller
{
    public function store(UploadCategoryImageRequest $request, string $id){
        $category = Category::find($id);

        if(!$category){
            return ApiResponse::error(
                'Category Not Found',
                Response::HTTP_NOT_FOUND
            );
        }

        if($category->image){
            Storage::disk('public')->delete($category->image);
        }

        $path = $request->file('image')->store('categories','public');

        $category->updated(['image' => $path]);

        return ApiResponse::success(
            new CategoryResource($category),
            'Category image uploaded',
        );
    }
}
