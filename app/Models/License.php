<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class License extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'subtitle',  
        'desc1',
        'desc2',
        'image',
        'order',
        'status'
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    // Scope for active licenses
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope for ordered licenses
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    // Get active licenses in order for frontend
    public static function getActiveLicenses()
    {
        return self::active()->ordered()->get();
    }

    // Get all licenses ordered by order for admin
    public static function getAllOrdered()
    {
        return self::ordered()->get();
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
