<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'jenis_surat_keluar';
    
    protected $guarded = ['id'];

}
