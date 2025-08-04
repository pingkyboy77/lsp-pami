<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'image',
        'content',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('created_at', 'desc');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lembaga) {
            if (empty($lembaga->slug)) {
                $lembaga->slug = Str::slug($lembaga->title);
            }
        });

        static::updating(function ($lembaga) {
            if ($lembaga->isDirty('title')) {
                $lembaga->slug = Str::slug($lembaga->title);
            }
        });
    }
}
