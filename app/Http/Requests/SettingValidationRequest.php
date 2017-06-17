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
        if ($this->Path('admin/setting/api/mail/update/{slug}')) {
            return [
                'welcomeEmailHeading' => 'required|string|max:40',
                'welcomeEmailBody' => 'required'
            ];
        }
        if ($this->Path('admin/setting/api/key/{slug}')) {
            return [
                'api_key' => 'required|max:16'
            ];
        }
        if ($this->isPath('admin/setting/api/plan/{slug}')) {
            return [
                'plan_id' => 'required',
                'plan_name' => 'required',
                'plan_currency' => 'required',
                'plan_amount' => 'required|numeric',
                'plan_interval' => 'required',
                'plan_description' => 'required|max:22'
            ];
        }
        if ($this->isPath('admin/setting/api/email/{slug}')) {
            return [
                'contact_email' => 'required'
            ];
        }
        if ($this->Path('admin/setting/api/name/{slug}')) {
            return [
                'church_name' => 'required'
            ];
        }
        if ($this->Path('admin/setting/api/slider/upload')) {
            return [
                'file.*' => 'required|image'
            ];
        }
        if ($this->Path('admin/setting/applogo')) {
            return [
                'appLogo' => 'required|mimes:jpg,jpeg,png'
            ];
        }
    }
}
