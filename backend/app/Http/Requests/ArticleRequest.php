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

class ArticleRequest extends FormRequest
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
