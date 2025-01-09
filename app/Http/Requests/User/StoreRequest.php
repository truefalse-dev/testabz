<?php

namespace App\Http\Requests\User;

use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:60',
            'email' => 'required|unique:users,email|email',
            'position_id' => 'required|exists:user_positions,id',
            'phone' => ['required', 'unique:users,phone', new PhoneRule()],
            'photo' => 'required|mimes:jpeg,jpg|max:5120'
        ];
    }
}
