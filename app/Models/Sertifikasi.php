<?php

namespace App\Models;

use App\Models\UnitKompetensi;
use App\Models\PersyaratanDasar;
use App\Models\BiayaUjiKompetensi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sertifikasi extends Model
{
    use HasFactory;
    protected $table = 'sertifikasi';

    protected $fillable = ['title', 'slug', 'description', 'image', 'parent_id', 'sort_order', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship dengan parent
    public function parent()
    {
        return $this->belongsTo(Sertifikasi::class, 'parent_id');
    }

    // Relationship dengan children
    public function children()
    {
        return $this->hasMany(Sertifikasi::class, 'parent_id')->orderBy('sort_order');
    }

    // Unit Kompetensi (hasOne - hanya satu)
    public function unitKompetensi()
    {
        return $this->hasOne(UnitKompetensi::class);
    }

    // Persyaratan Dasar (hasOne - hanya satu)
    public function persyaratanDasar()
    {
        return $this->hasOne(PersyaratanDasar::class);
    }

    // Biaya Uji Kompetensi (hasOne - hanya satu)
    public function biayaUjiKompetensi()
    {
        return $this->hasOne(BiayaUjiKompetensi::class);
    }

    // Scope untuk parent sertifikasi
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    // Scope untuk child sertifikasi
    public function scopeChildren($query)
    {
        return $query->whereNotNull('parent_id');
    }

    // Scope untuk sertifikasi aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
