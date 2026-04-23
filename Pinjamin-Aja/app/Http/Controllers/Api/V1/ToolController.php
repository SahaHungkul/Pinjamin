<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetToolRequest;
use App\Http\Requests\StoreToolRequest;
use App\Http\Requests\UpdateToolRequest;
use App\Http\Resources\PaginatedResource;
use App\Http\Resources\ToolResource;
use App\Models\Tool;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ToolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetToolRequest $request)
    {
        $tools = Tool::with('category')->search($request->search)->latest()->paginate($request->limit ?? 10);

        return ApiResponse::success(
            new PaginatedResource($tools, ToolResource::class),
            'Tools List'
        );
    }

    public function option(GetToolRequest $request)
    {
        $tools = Tool::select('id', 'nama_alat')->search($request->search)->orderBy('nama_alat')->get();

        return ApiResponse::success(
            ToolResource::collection($tools),
            'Tools List'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreToolRequest $request)
    {
        $tool = Tool::create($request->validated());

        return ApiResponse::success(
            new ToolResource($tool->load('category')),
            'Tool created successfully',
            Response::HTTP_CREATED,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tool = Tool::with('category')->find($id);

        if (!$tool) {
            return ApiResponse::error(
                'Tool not found',
                Response::HTTP_NOT_FOUND,
            );
        }

        return ApiResponse::success(
            new ToolResource($tool),
            'Tool Details'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateToolRequest $request, string $id)
    {
        $tool = Tool::find($id);

        if (!$tool) {
            return ApiResponse::error(
                'Tool not found',
                Response::HTTP_NOT_FOUND,
            );
        }

        $tool->update($request->validated());

        return ApiResponse::success(
            new ToolResource($tool->load('category')),
            'Tool Update Successfully',
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tool = Tool::find($id);

        if (!$tool) {
            return ApiResponse::error(
                'Tool not found',
                Response::HTTP_NOT_FOUND,
            );
        }

        if ($tool->image) {
            Storage::disk('public')->delete($tool->image);
        }

        $tool->delete();

        return ApiResponse::success(
            null,
            'Tool Deleted Successfully'
        );
    }
}
