<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class uploadRequest extends Request
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
            // 'file' => 'bail|required|mimes:zip|max:63488',
            'file' => 'bail|required|max:63488',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'File is required',
            // 'file.mimes' => 'ZIP file only',
            'file.max' => 'Over 60 MB',
        ];
    }
}
