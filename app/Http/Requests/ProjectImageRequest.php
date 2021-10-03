<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ProjectImageRequest extends FormRequest
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
        if (Request::isMethod('post')){
            return [
                'project_id' => 'required',
                'title' => 'required|string',
                'file' => 'required|image|mimes:jpg,bmp,png',

            ];
        }else{
            return [
                'project_id' => 'required',
                'title' => 'required|string',
                'status' => 'required',
                'file' => 'nullable|image|mimes:jpg,bmp,png',
            ];
        }

    }

    public function messages()
    {
        return [
            'project_id.required' => 'The project field is required.',
        ];
    }
}
