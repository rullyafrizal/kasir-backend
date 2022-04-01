<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'paid' => ['required', 'numeric', 'min:0'],
            'change' => ['required', 'numeric', 'min:0'],
            'total_price' => ['required', 'numeric', 'min:0'],
            'transaction_items' => ['required', 'array']
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            $transaction_items = $this->request->get('transaction_items');

            foreach ($transaction_items as $item) {
                if ($item['quantity'] <= 0) {
                    $validator->errors()->add('transaction_items', 'Quantity must be greater than 0');
                }

                if ($item['subtotal'] <= 0) {
                    $validator->errors()->add('transaction_items', 'Subtotal must be greater than 0');
                }

                if (!is_numeric($item['quantity']) || !is_numeric($item['subtotal'])) {
                    $validator->errors()->add('transaction_items', 'Quantity and Subtotal must be numeric');
                }
            }
        });
    }
}
