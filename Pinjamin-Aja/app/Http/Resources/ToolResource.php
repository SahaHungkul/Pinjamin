<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ToolResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama_alat' => $this->nama_alat,
            'deskripsi' => $this->deskripsi,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'stok' => $this->stok,
            'denda_per_hari' => $this->denda_per_hari,
            'image' => $this->image ? Storage::disk('public')->url($this->image) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
