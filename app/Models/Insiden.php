<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insiden extends Model
{
    use HasFactory;

    protected $table = 'insiden';

    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
}
