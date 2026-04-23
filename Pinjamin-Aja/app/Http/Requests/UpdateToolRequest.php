<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateToolRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_alat' => 'sometimes|string|max:255',
            'deskripsi' => 'nullable|string',
            'category_id' => 'sometimes|exists:categories,id',
            'stok' => 'sometimes|integer|min:0',
            'denda_per_hari' => 'sometimes|numeric|min:0',
        ];
    }
}
