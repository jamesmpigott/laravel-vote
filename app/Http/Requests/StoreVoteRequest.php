<?php

namespace App\Http\Requests;

use App\Models\Poll;
use App\Jobs\ProcessVote;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreVoteRequest extends FormRequest
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
            'email' => 'required|unique:votes',
            'option_id' => 'required',
            'poll_slug' => 'required'
        ];
    }

    public function passedValidation() {
        $validated = $this->validator->validated();

        dispatch(new ProcessVote($validated, $this->ip()));
    }
}
