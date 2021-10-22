<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class BlogRequest extends FormRequest
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
                'title' => 'required',

            ];
        }else{
            return [
                'category_id' => 'required',
                'name' => 'required',
                'status' => 'required',
            ];
        }

    }

    public function messages()
    {
        return [
            'category_id.required' => 'The category field is required.',
        ];
    }
}
