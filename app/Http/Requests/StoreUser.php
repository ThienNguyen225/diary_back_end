<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

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
            'name' => 'required|string|min:6|max:25',
            'email' => "required|string|email|unique:users,email",
            'password' => 'required|string|min:6|max:25',
            'phone' => 'regex:/(0)[0-9]{9}/|unique:customers,phone',
            'age' => 'number',
            'image' => 'mimes:jpeg,png,bmp,gif,svg,jpg',
            'address' => 'string|min:6|max:255',
//            'date_of_birth' => 'required|before:today',
        ];
    }

    public function messages()
    {
        return $messages = [
            'required' => 'Trường :Attribute không được để trống',
            'string' => 'Trường :Attribute là kiểu chữ',
            'min' => 'Trường :Attribute ít nhất :min ký tự',
            'max' => 'Trường :Attribute nhiều nhất :max ký tự',
            'unique' => ':Attribute đã tồn tại',
            'email' => 'Hãy đền đúng định dạng :Attribute',
            'regex' => 'Hãy đền đúng định dạng :Attribute',
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(
            [
                'error' => $errors,
                'status_code' => 422,
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
