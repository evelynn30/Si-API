<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SifatSurat extends Model
{
    use HasFactory;
    protected $table = 'sifat_surat';

    protected $guarded = ['id'];
}
