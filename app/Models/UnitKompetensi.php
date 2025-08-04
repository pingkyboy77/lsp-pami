<?php

namespace App\Models;

use App\Models\Sertifikasi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitKompetensi extends Model
{
    use HasFactory;

    protected $table = 'unit_kompetensi';

    protected $fillable = ['sertifikasi_id', 'content'];

    public function sertifikasi()
    {
        return $this->belongsTo(Sertifikasi::class);
    }
}
