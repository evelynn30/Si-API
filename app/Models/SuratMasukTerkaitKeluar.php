<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasukTerkaitKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk_terkait_keluar';
    protected $guarded = ['id'];

    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class);
    }
    public function suratKeluar()
    {
        return $this->belongsTo(SuratKeluar::class);
    }
}
