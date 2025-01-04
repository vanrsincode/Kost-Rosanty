<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;

    protected $table    = 'fasilitas';
    protected $guarded  = [];

    public function kamar()
    {
        return $this->belongsToMany(Kamar::class, 'kamar_fasilitas', 'kamar_id', 'fasilitas_id');
    }
}
