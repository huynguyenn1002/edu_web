<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCourseRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'course_description' => 'required|string|max:500',
            'cost' => 'required|integer|digits_between:0,5',
            'avatar' => 'required|image|max:20000',
            'cover' => 'required|image|max:20000',
            'category_id' => 'required|integer',
            'content_type.*' => 'required|integer|between:0,3',
            'score.*' => 'required|integer|digits_between:0,5',
            'title.*' => 'required|string|max:255',
            'description.*' => 'required|string'
        ];
    }
}
