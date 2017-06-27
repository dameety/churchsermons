<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceValidationRequest extends FormRequest
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
                'name'        => 'required|max:30|unique:services',
                'description' => 'max:300',
            ];
        } else {
            return [
                'name'        => 'required|max:30',
                'description' => 'max:300',
            ];
        }
    }
}
