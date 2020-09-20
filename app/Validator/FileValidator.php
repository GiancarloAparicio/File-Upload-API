<?php

namespace App\Validator;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class FileValidator
{

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     *  Validate the request depending on the rules, if it is fulfilled it returns 
     *  only the correct fields, otherwise it returns an exception
     * 
     *  @return Array $validate
     */
    public function validate()
    {

        $validator = Validator::make(
            $this->request->all(),
            $this->rules(),
            $this->messages()
        );

        if ($validator->fails()) {
            throw new ValidationException(
                $validator,
                new JsonResponse($validator->errors()->getMessages(), 422)
            );
        }

        return $validator->validateWithBag('post');
    }

    public function rules()
    {
        return [
            'file' => ['file', 'max:2048', 'required']
        ];
    }

    public function messages()
    {

        return [
            'file.file' => 'The :attribute must be a file.',
            'file.required' => 'The :attribute field is required.',
            'file.max' => 'The :attribute may not be greater than :max kilobytes.'
        ];
    }
}
