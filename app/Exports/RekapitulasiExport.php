<?php

namespace App\Exports;

use App\Models\Temuan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RekapitulasiExport implements FromView
{
    protected $data, $typeExport;

    // Accept the filtered data via the constructor
    public function __construct($data, $typeExport)
    {
        $this->data = $data;
        $this->typeExport = $typeExport;
    }


    public function view(): View
    {
        if ($this->typeExport == 1) {
            return view('components.partials.tables.temuan-table', [
                'data' => $this->data,
            ]);
        } else if ($this->typeExport == 2) {
            return view('components.partials.tables.surat-keluar-table', [
                'data' => $this->data,
                'opdReq' => null // or pass the appropriate value if available
            ]);
        } else if ($this->typeExport == 3) {
            return view('components.partials.tables.surat-masuk-table', [
                'data' => $this->data,
                'opdReq' => null // or pass the appropriate value if available
            ]);
        }
    }
}
