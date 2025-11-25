<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Mapear campos enviados pelo front
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'name' => $this->input('nome'),
            'code' => $this->input('codigo'),
            'min_quantity' => $this->input('quantidadeMinima'),
            'perishable' => $this->input('perecivel'),
            'nutrition_facts' => $this->input('informacaoNutricional'),
            'unit_id' => $this->input('unidadeMedida'),
            'category_id' => $this->input('categoria'),
            'brand_id' => $this->input('marca'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:85'],
            'code' => ['required', 'string', 'max:20', 'unique:products,code'],
            'min_quantity' => ['required', 'integer', 'min:0'],
            'perishable' => ['boolean'],
            'nutrition_facts' => ['nullable', 'array'], // JSON -> array
            'unit_id' => ['required', 'integer', 'exists:measurement_units,id'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'brand_id' => ['required', 'integer', 'exists:brands,id'],
        ];
    }
}
