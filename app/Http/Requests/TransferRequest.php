<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{

    /**
     * @inheritDoc
     */
    public function wantsJson() {
        return true;
    }

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
            'amount' => 'required|numeric|min:1',
            'sender_wallet_id' => 'required|integer|exists:wallets,id',
            'destination_wallet_id' => 'required|integer|different:sender_wallet_id|exists:wallets,id',
        ];
    }
}
