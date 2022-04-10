<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePollRequest extends FormRequest
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
            'title' => 'required',
            'options.*.value' => 'required',
            'options.*.color' => 'required|string|min:7|max:7|starts_with:#',
            'anon_voting' => 'boolean',
            'geolocation_tracking' => 'boolean',
        ];
    }
}
