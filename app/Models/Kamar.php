<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $table = 'kamar';
    protected $guarded = [];

    public function fasilitas()
    {
        return $this->belongsToMany(Fasilitas::class, 'kamar_fasilitas', 'kamar_id', 'fasilitas_id');
    }

    public function sewaKamar()
    {
        return $this->hasMany(SewaKamar::class);
    }
}
