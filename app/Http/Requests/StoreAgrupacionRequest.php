<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAgrupacionRequest extends FormRequest
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
            'nombre_agrupacion'      => 'required|string|max:100',
            'nombre_representante'   => 'required|string|max:100',
            'email_representante' => [
                'required',
                'email',
                'regex:/^[^@]+@(gmail|hotmail|outlook)\.com$/i',
                'unique:agrupaciones,email_representante',
            ],
            'curp_representante' => [
                'required',
                'string',
                'regex:/^[A-Z]{4}\d{6}[HM][A-Z]{5}[0-9A-Z]\d$/',
                'size:18',
                'unique:agrupaciones,curp_representante',
            ],
            'rfc_agrupacion' => [
                'required',
                'string',
                'size:12',
                'regex:/^[A-ZÑ&]{3,4}\d{6}[A-Z0-9]{3}$/',
                'unique:agrupaciones,rfc_agrupacion',
            ],
            'direccion_agrupacion'   => 'required|string|max:255',
            'superficie_cosecha'     => 'required|numeric|min:0.1|max:50', // en hectáreas
            'tipo_suelo'             => 'required|string|max:100',
            'num_trabajadores'       => 'required|integer|min:1|max:1000',
            'tipo_maquinaria'        => 'required|string|max:255',
            'horas_trabajo'          => 'required|integer|min:1|max:168',
            'certificaciones'        => 'required|string|max:255',
            'fecha_inicio'           => 'required|date',
            'fecha_cosecha'          => 'required|date|after_or_equal:fecha_inicio',
        ];
    }
    public function messages(): array
    {
        return [
            'nombre_agrupacion.required' => 'El nombre de la agrupación es obligatorio.',
            'nombre_agrupacion.max' => 'El nombre de la agrupación no debe superar los 100 caracteres.',

            'nombre_representante.required' => 'El nombre del representante es obligatorio.',
            'nombre_representante.max' => 'El nombre del representante no debe superar los 100 caracteres.',

            'email_representante.required' => 'El correo electrónico del representante es obligatorio.',
            'email_representante.email' => 'El formato del correo no es válido.',
            'email_representante.regex' => 'El correo debe tener una extensión válida como .com, .mx, .org, etc.',
            'email_representante.unique' => 'Este correo ya ha sido registrado.',

            'curp_representante.required' => 'El CURP es obligatorio.',
            'curp_representante.regex' => 'El CURP debe tener un formato válido (18 caracteres, letras y números).',
            'curp_representante.unique' => 'Este CURP ya ha sido registrado.',

            'rfc_agrupacion.required' => 'El RFC es obligatorio.',
            'rfc_agrupacion.regex' => 'El RFC debe tener un formato válido (13 caracteres con letras y números en orden específico).',
            'rfc_agrupacion.unique' => 'Este RFC ya ha sido registrado.',

            'direccion_agrupacion.required' => 'La dirección es obligatoria.',
            'direccion_agrupacion.max' => 'La dirección no debe superar los 255 caracteres.',

            'superficie_cosecha.required' => 'La superficie de cosecha es obligatoria.',
            'superficie_cosecha.min' => 'Debe ser al menos 0.1 hectáreas.',
            'superficie_cosecha.max' => 'No debe exceder las 50 hectáreas.',

            'tipo_suelo.required' => 'El tipo de suelo es obligatorio.',
            'tipo_suelo.max' => 'El tipo de suelo no debe superar los 100 caracteres.',

            'num_trabajadores.required' => 'El número de trabajadores es obligatorio.',
            'num_trabajadores.integer' => 'Debe ser un número entero.',
            'num_trabajadores.min' => 'Debe haber al menos un trabajador.',
            'num_trabajadores.max' => 'No puede haber más de 1000 trabajadores.',

            'tipo_maquinaria.required' => 'El tipo de maquinaria es obligatorio.',
            'tipo_maquinaria.max' => 'La descripción de la maquinaria no debe superar los 255 caracteres.',

            'horas_trabajo.required' => 'Las horas de trabajo semanales son obligatorias.',
            'horas_trabajo.integer' => 'Debe ser un número entero.',
            'horas_trabajo.min' => 'Debe ser al menos 1 hora semanal.',
            'horas_trabajo.max' => 'No puede exceder las 168 horas por semana.',

            'certificaciones.required' => 'Las certificaciones son obligatorias.',
            'certificaciones.max' => 'Las certificaciones no deben superar los 255 caracteres.',

            'fecha_inicio.required' => 'La fecha de inicio de siembra es obligatoria.',
            'fecha_inicio.date' => 'El formato de la fecha de siembra no es válido.',

            'fecha_cosecha.required' => 'La fecha de cosecha es obligatoria.',
            'fecha_cosecha.date' => 'El formato de la fecha de cosecha no es válido.',
            'fecha_cosecha.after_or_equal' => 'La fecha de cosecha debe ser igual o posterior a la fecha de siembra.',
        ];
    }
}
