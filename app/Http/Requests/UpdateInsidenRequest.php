<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInsidenRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->status == 'on' ? 1 : 0,
        ]);
    }
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $insiden = $this->route('insiden'); // Mengambil model opd dari route

        return [
            'nama' => ['required',  Rule::unique('insiden')->ignore($insiden)],
            'deskripsi' => 'required',
            'status' => 'boolean',

        ];
    }
}