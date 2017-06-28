<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserValidationRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return [
                'name' => 'required|max:30',
                'password' => 'required|min:8',
                'email' => 'required|email|unique:users|max:30'
            ];
        } else {
            return [
                'password' => 'required|min:8'
            ];
        }

        if ($this->is('/user/profile/update')) {
            return [
                'name' => 'required|string'
            ];
        }
    }
}
