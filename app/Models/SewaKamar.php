<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SewaKamar extends Model
{
    use HasFactory;

    protected $table = 'sewa_kamar';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($sewaKamar) {
            $sewaKamar->kamar->update(['status_kamar' => 'Terpakai']);
        });

        // static::updated(function ($sewaKamar) {
        //     if (!is_null($sewaKamar->tgl_selesai_sewa)) {
        //         $sewaKamar->kamar->update(['status_kamar' => 'Tersedia']);
        //     }
        // });

        // static::deleted(function ($sewaKamar) {
        //     $sewaKamar->kamar->update(['status_kamar' => 'Tersedia']);
        // });
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kamar_id');
    }

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class, 'penghuni_id');
    }
}
