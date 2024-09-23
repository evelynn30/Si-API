<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penemu extends Model
{
    use HasFactory;

    protected $table = 'penemu';

    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
}
