<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penghuni extends Model
{
    use HasFactory;

    protected $table = 'penghuni';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sewaKamar()
    {
        return $this->hasOne(SewaKamar::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'penghuni_id', 'id');
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }
}
