<?php

namespace App\Models;

use App\Models\Insiden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemuanInsiden extends Model
{
    use HasFactory;

    protected $table = 'temuan_insiden';
    protected $guarded = ['id'];

    public function insiden()
    {
        return $this->belongsTo(Insiden::class);
    }
    public function temuan()
    {
        return $this->belongsTo(Temuan::class);
    }
    
}
