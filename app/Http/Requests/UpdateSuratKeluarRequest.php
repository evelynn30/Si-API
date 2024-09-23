<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSuratKeluarRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'is_attachment' => $this->is_attachment == 'on' ? 1 : 0,
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
        return [
            'jenis_surat_keluar' => 'required',
            'data_temuan' => $this->jenis_surat_keluar == 1 ? 'required' : '',
            'opd' => $this->jenis_surat_keluar != 1 ? 'required' : '',
            'tanggal' => 'required|date',
            'nomor' => 'required',
            'sifat_surat' => 'required',
            'perihal_surat' => 'required',
            // 'is_attachment' => 'required',
            'file' => 'nullable|mimes:pdf|max:5120',
        ];
    }

    protected function passedValidation()
    {
        $this->merge([
            'jenis_surat_keluar_id' => $this->jenis_surat_keluar,
            'sifat_surat_id' => $this->sifat_surat,
            'perihal_surat_id' => $this->perihal_surat,
        ]);

        $dataUnset = ['jenis_surat_keluar', 'sifat_surat', 'perihal_surat'];

        if ($this->jenis_surat_keluar != 1) {
            $dataUnset[] = 'data_temuan';
        } else {
            $dataUnset[] = 'opd';
        }

        $this->replace(
            $this->except($dataUnset)
        );
    }
}
