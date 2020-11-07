<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestTracing extends FormRequest
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
          'user_id' => 'required|max:200|unique:tracings',
          'state' => 'required'
        ];
    }

    //Custom messages errors
    public function messages()
    {
        return [
          'name.unique' => 'El nombre ya esta en uso',
        ];
    }
}
