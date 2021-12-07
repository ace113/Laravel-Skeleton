<?php

namespace App\Http\Transformers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserTransformer
{
    public function createJson($data)
    {
        return [
            'first_name' => Arr::get($data, 'first_name', null),
            'last_name' => Arr::get($data, 'last_name', null),
            'email' => Arr::get($data, 'email', null),
            'phone' => Arr::get($data, 'phone', null),
            'role_id' => $data->role_id ?? null,
            'password' => Hash::make(Arr::get($data, 'password', null)),
            'gender' => Arr::get($data, 'gender', null),
            'email_verify_token' => $data->email_verify_token ?? null,
        ];
    }

    public function updateJson($data)
    {
        return [
            'first_name' => Arr::get($data, 'first_name', null),
            'last_name' => Arr::get($data, 'last_name', null),
            'email' => Arr::get($data, 'email', null),
            'phone' => Arr::get($data, 'phone', null),
            'gender' => Arr::get($data, 'gender', null),
        ];
    }
}