<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PedidoRequest extends FormRequest
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
            'cliente' => 'required|string|max:255',
            'itens' => 'required|array|min:1',
            'itens.*.produto_id' => 'required|exists:produtos,id',
            'itens.*.quantidade' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'cliente.required' => 'O nome do cliente é obrigatório.',
            'cliente.string' => 'O nome do cliente deve ser um texto.',
            'cliente.max' => 'O nome do cliente não pode ter mais de 255 caracteres.',
            'itens.required' => 'É necessário adicionar pelo menos um item ao pedido.',
            'itens.array' => 'Os itens devem estar em formato de lista.',
            'itens.min' => 'O pedido deve conter ao menos um item.',
            'itens.*.produto_id.required' => 'O produto é obrigatório para cada item do pedido.',
            'itens.*.produto_id.exists' => 'O produto informado não existe.',
            'itens.*.quantidade.required' => 'A quantidade é obrigatória para cada item do pedido.',
            'itens.*.quantidade.integer' => 'A quantidade deve ser um número inteiro.',
            'itens.*.quantidade.min' => 'A quantidade mínima por item é 1.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'error' => $validator->errors()->first(),
        ], 422));
    }
}
