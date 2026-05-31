<?php

namespace App\Http\Requests;

class UpdateWorkflowRequest extends StoreWorkflowRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['title'] = ['sometimes', 'required', 'string', 'max:160'];

        return $rules;
    }
}
