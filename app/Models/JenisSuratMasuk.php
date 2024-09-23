<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'jenis_surat_masuk';

    protected $guarded = ['id'];
}
