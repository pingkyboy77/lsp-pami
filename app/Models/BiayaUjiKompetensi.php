<?php

namespace App\Models;

use App\Models\Sertifikasi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BiayaUjiKompetensi extends Model
{
    use HasFactory;
    protected $table = 'biaya_uji_kompetensi';

    protected $fillable = ['sertifikasi_id', 'content'];

    public function sertifikasi()
    {
        return $this->belongsTo(Sertifikasi::class);
    }
}
