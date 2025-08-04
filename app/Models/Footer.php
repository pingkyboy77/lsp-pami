<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Footer extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'description',
        'map_embed',
        'address',
        'phone',
        'email',
        'city',
        'socials',
        'certification_title',
        'certification_links',
        'subscription_title',
        'subscription_text',
        'subscription_button',
        'subscription_url',
    ];
    protected $casts = [
        'socials' => 'array',
        'certification_links' => 'array',
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
