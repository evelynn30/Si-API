<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluarOpd extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar_opd';
    protected $guarded = ['id'];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
    public function suratKeluar()
    {
        return $this->belongsTo(SuratKeluar::class);
    }
}
