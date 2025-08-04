<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminGaleri extends Model
{
    use HasFactory;
    protected $table = 'admin_galeris';

    protected $fillable = ['title', 'images'];

    protected $casts = [
        'images' => 'array',
    ];
}
