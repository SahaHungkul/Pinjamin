<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadToolImageRequest;
use App\Http\Resources\ToolResource;
use App\Models\Tool;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ToolImageController extends Controller
{
    public function store(UploadToolImageRequest $request, string $id)
    {
        $tool = Tool::find($id);

        if (!$tool) {
            return ApiResponse::error(
                'Tool Not Found',
                Response::HTTP_NOT_FOUND
            );
        }

        if ($tool->image) {
            Storage::disk('public')->delete($tool->image);
        }

        $path = $request->file('image')->store('tools', 'public');

        $tool->update(['image' => $path]);

        return ApiResponse::success(
            new ToolResource($tool->load('category')),
            'Tool image uploaded',
        );
    }
}
