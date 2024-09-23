<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSuratMasukRequest extends FormRequest
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
            'jenis_surat_masuk' => 'required',
            'data_surat_keluar' => $this->jenis_surat_masuk == 1 ? 'required' : '',
            'opd' => $this->jenis_surat_masuk != 1 ? 'required' : '',
            'tanggal' => 'required|date',
            'nomor' => 'required',
            'sifat_surat' => 'required',
            'perihal_surat' => 'required',
            'file' => 'required|mimes:pdf|max:5120',
        ];
    }

    protected function passedValidation()
    {
        // Set 'jenis_surat_id' to have the same value as 'jenis_surat'
        $this->merge([
            'jenis_surat_masuk_id' => $this->jenis_surat_masuk,
            'sifat_surat_id' => $this->sifat_surat,
            'perihal_surat_id' => $this->perihal_surat,
        ]);

        // unset jenis_surat_id, sifat_surat_id, perihal_surat_id
        $dataUnset = ['jenis_surat_masuk', 'sifat_surat', 'perihal_surat'];

        if ($this->jenis_surat_masuk != 1) {
            $dataUnset[] = 'data_surat_keluar';
        } else {
            $dataUnset[] = 'opd';
        }
        $this->replace(
            $this->except($dataUnset)
        );
    }
}
