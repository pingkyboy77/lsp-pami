<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminProsesUjikom extends Model
{
    use HasFactory;
    protected $table = 'proses_ujikoms';

    protected $fillable = ['title', 'images'];

    protected $casts = [
        'images' => 'array',
    ];
}
