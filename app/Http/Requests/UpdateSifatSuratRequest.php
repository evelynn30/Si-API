<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSifatSuratRequest extends FormRequest
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
        $sifatSurat = $this->route('sifat_surat'); // Mengambil model dari route

        return [
            'nama' => ['required',  Rule::unique('sifat_surat')->ignore($sifatSurat)],
            'status' => 'boolean',
        ];
    }
}
