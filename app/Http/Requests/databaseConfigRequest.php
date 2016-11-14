<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class databaseConfigRequest extends FormRequest
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
            'host_name'     =>  'required',
            'user_name'     =>  'required',
            'user_pwd'      =>  '',
            'db_name'       =>  'required',
            'db_prefix'     =>  'required'
        ];
    }
}
