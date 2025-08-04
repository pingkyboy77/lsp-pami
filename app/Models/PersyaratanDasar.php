<?php

namespace App\Models;

use App\Models\Sertifikasi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersyaratanDasar extends Model
{
    use HasFactory;

    protected $table = 'persyaratan_dasar';

    protected $fillable = ['sertifikasi_id', 'content'];

    public function sertifikasi()
    {
        return $this->belongsTo(Sertifikasi::class);
    }
}
