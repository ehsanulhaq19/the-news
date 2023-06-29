<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class AuthRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $rules = [];

        switch ($request->path()) {
            case 'api/v1/register':
                $rules = [
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|min:8|max:20',
                    'first_name' => 'required|max:50',
                    'last_name' => 'required|max:50'
                ];
                break;
            case 'api/v1/login':
                $rules = [
                    'email' => 'required|email|max:255',
                    'password' => 'required|min:8|max:20'
                ];
                break;
        }
        return $rules;
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $message = $validator->errors()->first();
        $rescode = SymfonyResponse::HTTP_BAD_REQUEST;
        $values = new \stdClass();
        $response = new JsonResponse([
            'status' => $rescode,
            'message' =>  $message
        ], $rescode);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
