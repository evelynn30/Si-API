<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerihalSurat extends Model
{
    use HasFactory;
    
    protected $table = 'perihal_surat';

    protected $guarded = ['id'];

}
