<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProfileSection extends Model
{
    use HasFactory;
    protected $fillable = [
        'key',
        'title',
        'content',
        'order'
    ];

    protected $casts = [
        'order' => 'integer'
    ];

    // Scope untuk mengurutkan berdasarkan order
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    // Accessor untuk konten yang di-strip HTML jika dibutuhkan
    public function getContentPreviewAttribute()
    {
        return \Str::limit(strip_tags($this->content), 100);
    }

    protected static function booted()
    {
        static::creating(function ($profile) {
            $profile->created_by = Auth::id();
        });

        static::updating(function ($profile) {
            $profile->updated_by = Auth::id();
        });
    }
}
