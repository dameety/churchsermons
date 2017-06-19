<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingValidationRequest extends FormRequest
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

    public function rulwes()
    {
        //
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        if ($this->is('admin/setting/api/mail/update/{slug}')) {
            return [
                'welcomeEmailHeading' => 'required|string|max:40',
                'welcomeEmailBody' => 'required'
            ];
        } elseif ($this->is('admin/setting/api/key')) {
            return [
                'api_key' => 'required|max:32'
            ];
        } elseif ($this->is('admin/setting/api/plan/{slug}')) {
            return [
                'plan_id' => 'required',
                'plan_name' => 'required',
                'plan_currency' => 'required',
                'plan_amount' => 'required|numeric',
                'plan_interval' => 'required',
                'plan_description' => 'required|max:22'
            ];
        } elseif ($this->is('admin/setting/api/email/{slug}')) {
            return [
                'contactEmail' => 'required'
            ];
        } elseif ($this->is('admin/setting/api/name/{slug}')) {
            return [
                'churchName' => 'required'
            ];
        } elseif ($this->is('admin/setting/api/slider/upload')) {
            return [
                'file.*' => 'required|image'
            ];
        } elseif ($this->is('admin/setting/applogo')) {
            return [
                'appLogo' => 'required|mimes:jpg,jpeg,png'
            ];
        }
    }
}
