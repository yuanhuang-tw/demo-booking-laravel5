<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreInterviewRequest extends Request
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
            'contact' => 'required',
            'date' => [
                'bail',
                'required',
                'date',
                'after:-1 day',
            ],
            'time' => [
                'bail',
                'required',
                'regex:/^([0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/',
            ],
            'client' => 'required',
            's_status' => 'required',
            'i_type' => 'required',
            'language' => 'required',
            'tp' => 'required',
            'interviewee' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'contact.required' => '"ICRT Sales / Contact" can NOT empty',
            'date.required' => '"Interview Date" can NOT empty',
            'date.date' => '"Interview Date" error',
            'date.after' => '"Interview Date" error',
            'time.required' => '"Interview Time" can NOT empty',
            'time.regex' => '"Interview Time" error',
            'client.required' => '"Client" can NOT empty',
            's_status.required' => 'Please choose "Scheduling Status"',
            'i_type.required' => 'Please choose "Interview Type"',
            'language.required' => 'Please choose "Language"',
            'tp.required' => '"Talking Points" can NOT empty',
            'interviewee.required' => '"Interviewee / bio" can NOT empty',
        ];
    }
}
