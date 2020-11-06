<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestGender extends FormRequest
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
          'name' => 'required|max:200|unique:genders',
          'initials' => 'required|max:5|unique:genders',
          'state' => 'required'
        ];
    }

    //Custom messages errors
    public function messages()
    {
        return [
          'name.unique' => 'El nombre ya esta en uso',
          'initials.unique' => 'Las iniciales ya estan en uso'
        ];
    }
}
