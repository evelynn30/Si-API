<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTemuanRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'tanggal' => 'required',
            'opd' => 'required|exists:opd,id',
            'penemu' => 'required|exists:penemu,id',
            'url' => 'required|active_url',
            'insiden' => 'required|exists:insiden,id',
            'status' => 'required',
            'gambar' => 'required|mimes:jpeg,png,jpg|max:5120',

        ];
    }

    protected function passedValidation()
    {
        // Set 'jenis_surat_id' to have the same value as 'jenis_surat'
        $this->merge([
            'insiden_id' => $this->insiden,
            'opd_id' => $this->opd,
            'penemu_id' => $this->penemu,
        ]);

        // unset jenis_surat_id, sifat_surat_id, perihal_surat_id
        $this->replace(
            $this->except(['insiden', 'opd', 'penemu'])
        );
    }
}
