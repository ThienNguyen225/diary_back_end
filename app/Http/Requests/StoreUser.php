<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
            'name' => 'required|min:4|regex:/(^([a-zA-Z ]+)(\d+)?$)/u',
            'email' => "required|email|unique:customers,email,$this",
            'password' => 'required|min:6',
//            'phone' => 'required|regex:/(0)[0-9]{9}/|unique:customers,phone',
//            'date_of_birth' => 'required|before:today',
//            'inputFile' => 'required|mimes:jpeg,png,bmp,gif,svg,jpg',
        ];
    }
}
