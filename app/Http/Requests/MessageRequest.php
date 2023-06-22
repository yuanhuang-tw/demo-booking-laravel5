<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MessageRequest extends Request
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
            'date1' => 'bail|required|date|before:date2',
            'date2' => 'bail|required|date',
            'msg' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'date1.required' => '"Start Date" can NOT empty',
            'date1.date' => '"Start Date" error',
            'date1.before' => 'The "Start Date" must be a date before "End Date"',
            'date2.required' => '"End Date" can NOT empty',
            'date2.date' => '"End Date" error',
            'msg.required' => '"Messages" can NOT empty',
        ];
    }
}
