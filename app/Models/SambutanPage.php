<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SambutanPage extends Model
{
    use HasFactory;
    protected $fillable = ['page_title', 'pengarah_name', 'pengarah_title', 'pengarah_image', 'pengarah_content', 'pelaksana_name', 'pelaksana_title', 'pelaksana_image', 'pelaksana_content', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Method untuk mendapatkan data yang sudah diformat
    public function getFormattedData()
    {
        $data = [];

        // Page title
        if (!empty($this->page_title)) {
            $data['page_title'] = $this->page_title;
        }

        // Sambutan Pengarah
        if (!empty($this->pengarah_name) || !empty($this->pengarah_content)) {
            $data['sambutan_pengarah'] = [
                'name' => $this->pengarah_name,
                'title' => $this->pengarah_title,
                'image' => $this->pengarah_image,
                'content' => $this->pengarah_content,
            ];
        }

        // Sambutan Pelaksana
        if (!empty($this->pelaksana_name) || !empty($this->pelaksana_content)) {
            $data['sambutan_pelaksana'] = [
                'name' => $this->pelaksana_name,
                'title' => $this->pelaksana_title,
                'image' => $this->pelaksana_image,
                'content' => $this->pelaksana_content,
            ];
        }

        return $data;
    }

    // Scope untuk data aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Method untuk mendapatkan instance singleton
    public static function getInstance()
    {
        return self::active()->first() ?? new self();
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
