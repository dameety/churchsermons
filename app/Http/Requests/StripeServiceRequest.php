<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StripeServiceRequest extends FormRequest
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
        if ($this->is('/user/upgrade/action')) {
            return [
                'stripeToken' => 'required'
            ];
        } elseif ($this->is('/subscription/cancel')) {
            return [
                'deactivate' => 'required'
            ]
        } elseif ($this->is('/user/card/update/{id}')) {
            return [
                'stripeToken' => 'required'
            ];
        }
    }
}
