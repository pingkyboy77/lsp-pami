<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CertificationScheme extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'icon',
        'url',
        'button',
    ];

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
