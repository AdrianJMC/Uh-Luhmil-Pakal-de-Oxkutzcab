<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProveedorRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre'             => 'required|string|max:100',
            'edad'               => 'nullable|integer|min:0|max:120',
            'nacionalidad'       => 'nullable|string|max:50',
            'curp'               => 'required|string|size:18|unique:proveedores,curp',
            'rfc'                => 'nullable|string|size:13|unique:proveedores,rfc',
            'ubicacion'          => 'nullable|string|max:255',
            'superficie_cosecha' => 'nullable|numeric|min:0',
            'tipo_suelo'         => 'nullable|string|max:100',
        ];
    }
}
