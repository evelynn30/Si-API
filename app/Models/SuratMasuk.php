<?php

namespace App\Models;

use App\Models\SifatSurat;
use App\Models\PerihalSurat;
use App\Models\JenisSuratMasuk;
use App\Models\SuratMasukOpd;
use App\Models\SuratMasukTerkaitKeluar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk';
    protected $guarded = ['id'];

    public function sifatSurat()
    {
        return $this->belongsTo(SifatSurat::class);
    }
    public function perihalSurat()
    {
        return $this->belongsTo(PerihalSurat::class);
    }
    public function jenisSuratMasuk()
    {
        return $this->belongsTo(JenisSuratMasuk::class);
    }
    public function suratMasukOpd()
    {
        return $this->hasMany(SuratMasukOpd::class);
    }
    public function suratMasukTerkaitKeluar()
    {
        return $this->hasMany(SuratMasukTerkaitKeluar::class);
    }
}
