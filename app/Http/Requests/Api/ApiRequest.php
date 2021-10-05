<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiRequest extends FormRequest
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
            //
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = json_decode(json_encode($validator->errors()), true);

        $errors = call_user_func_array('array_merge', array_values($errors));

        $response = [
            'data' => (object)[],
            'status' => EXPECTATION_FAILED,
            'message' => implode(PHP_EOL, $errors),
            'errors' => $validator->messages(),
        ];

        throw new HttpResponseException(response()->json($response, EXPECTATION_FAILED));
    }
}
