<?php

namespace App\Http\Requests;

use App\Models\PasswordEntry;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateEntriesOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'entries' => 'required|array'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            /** @var User */
            $user = Auth::user();

            // Check use has access to all entries.
            foreach ($this->input('entries') as $index => $entry) {
                $entry = PasswordEntry::find($entry['id']);

                if (!$user->can('view', $entry)) {
                    $validator->errors()->add('entries.' . $index, 'Access denied.');
                }
            }
        });
    }
}
