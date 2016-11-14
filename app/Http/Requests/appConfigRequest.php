<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class appConfigRequest extends FormRequest
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
            'app_name'                  =>  'required',
            'admin_name'                =>  'min:5|required',
            'admin_email'               =>  'email|required',
            'admin_pwd'                 =>  'min:5|required|confirmed',
            'admin_pwd_confirmation'    =>  'required'
        ];
    }
}
