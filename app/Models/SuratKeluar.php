<?php

namespace App\Models;

use App\Models\SifatSurat;
use App\Models\PerihalSurat;
use App\Models\JenisSuratKeluar;
use App\Models\SuratKeluarTemuan;
use App\Models\SuratKeluarOpd;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar';
    protected $guarded = ['id'];

    public function sifatSurat()
    {
        return $this->belongsTo(SifatSurat::class);
    }
    public function perihalSurat()
    {
        return $this->belongsTo(PerihalSurat::class);
    }
    public function jenisSuratKeluar()
    {
        return $this->belongsTo(JenisSuratKeluar::class);
    }
    public function suratKeluarTemuan()
    {
        return $this->hasMany(SuratKeluarTemuan::class);
    }
    public function suratMasukTerkaitKeluar()
    {
        return $this->hasMany(SuratMasukTerkaitKeluar::class);
    }
    public function suratKeluarOpd()
    {
        return $this->hasMany(SuratKeluarOpd::class);
    }
}
