<?php

namespace App\Http\Requests;

use App\Models\opd;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOpdRequest extends FormRequest
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
        $opd = $this->route('opd'); // Mengambil model opd dari route

        return [
            'nama' => ['required',  Rule::unique('opd')->ignore($opd)],
            'alamat' => 'required',
            'narahubung' => 'required',
            'no_telp' => 'required|numeric|digits_between:8,13',
            'status' => 'boolean',

        ];
    }
}