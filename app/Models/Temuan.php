<?php

namespace App\Models;

use App\Models\Penemu;
use App\Models\Opd;
use App\Models\TemuanInsiden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temuan extends Model
{
    use HasFactory;

    protected $table = 'temuan';
    protected $guarded = ['id'];

    public function updateStatusToMenungguTanggapan()
    {
        // Change status to "Menunggu Tanggapan" when there is a Surat Penyampaian
        $this->status = 1;
        $this->save();
    }

    public function updateStatusToDalamPenanganan()
    {
        // Change status to "Dalam Penanganan" when there is a Surat Balasan
        $this->status = 2;
        $this->save();
    }

    public function penemu()
    {
        return $this->belongsTo(Penemu::class);
    }
    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function temuanInsiden()
    {
        return $this->hasMany(TemuanInsiden::class);
    }
    public function suratKeluarTemuan()
    {
        return $this->hasMany(SuratKeluarTemuan::class);
    }
    public function suratMasukTerkaitKeluar()
    {
        return $this->hasMany(SuratMasukTerkaitKeluar::class);
    }
}
