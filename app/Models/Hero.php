<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Hero extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'highlight', 'description', 'image', 'cta_1', 'cta_2', 'badge', 'date'];

    protected $casts = [
        'cta_1' => 'array',
        'cta_2' => 'array',
        'badge' => 'array',
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
