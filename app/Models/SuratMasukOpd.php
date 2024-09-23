<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasukOpd extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk_opd';
    protected $guarded = ['id'];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
    public function SuratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class);
    }
}
