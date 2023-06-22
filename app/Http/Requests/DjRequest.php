<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DjRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return false;
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
            'date' => 'bail|required|date',
            'start_hour' => 'bail|required|numeric|between:7,22',
            'end_hour' => 'bail|required|numeric|between:7,22|greater_than_field:start_hour',
            'msg' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '"Date" can NOT empty',
            'date.date' => '"Date" error',

            'start_hour.required' => '"Start Hour" can NOT empty',
            'start_hour.numeric' => '"Start Hour" error',
            'start_hour.between' => '"Start Hour" error',

            'end_hour.required' => '"End Hour" can NOT empty',
            'end_hour.numeric' => '"End Hour" error',
            'end_hour.between' => '"End Hour" error',
            'end_hour.greater_than_field' => '"End Hour" error',

            'msg.required' => '"Messages" can NOT empty',
        ];
    }
}
