<?php

namespace App\Models;

use App\Models\Temuan;
use App\Models\SuratKeluar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluarTemuan extends Model
{
    use HasFactory;
    protected $table = 'surat_keluar_temuan';

    protected $guarded = ['id'];

    public function temuan()
    {
        return $this->belongsTo(Temuan::class);
    }

    public function suratKeluar()
    {
        return $this->belongsTo(SuratKeluar::class);
    }

    public function balasanSuratKeluar()
    {
        return $this->hasMany(SuratMasukTerkaitKeluar::class, 'surat_keluar_id', 'surat_keluar_id');
    }
}
