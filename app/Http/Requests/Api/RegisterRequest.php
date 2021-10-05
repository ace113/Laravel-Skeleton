<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends ApiRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|numeric|exists:users,phone,'.$this->id,
            'email' => 'required|email|exists:users,email,'.$this->id,
            'gender' => 'nullable|in:male,female,other',
        ];
    }
}
