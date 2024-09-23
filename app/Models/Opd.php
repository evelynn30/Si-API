<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    use HasFactory;

    protected $table = 'opd';

    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    public function suratKeluarOpd()
    {
        return $this->hasMany(SuratKeluarOpd::class);
    }

    public function suratMasukOpd()
    {
        return $this->hasMany(SuratMasukOpd::class);
    }

    public function temuan()
    {
        return $this->hasMany(Temuan::class);
    }
}
