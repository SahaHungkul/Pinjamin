<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreToolRequest extends FormRequest
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
            'nama_alat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'stok' => 'required|integer|min:0',
            'denda_per_hari' => 'required|numeric|min:0',
        ];
    }
}
