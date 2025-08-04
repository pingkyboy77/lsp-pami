<?php

namespace App\Models;

use App\Models\Sertifikasi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PesertaSertifikat extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'sertifikasi', 'no_ser', 'no_reg', 'no_sertifikat', 'tanggal_terbit', 'tanggal_exp', 'registrasi_nomor', 'tahun_registrasi', 'nomor_blanko'];
}
