<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LicenseSetting extends Model
{
    use HasFactory;
    protected $table = 'license_settings';
    
    protected $fillable = [
        'key',
        'value', 
        'type',
        'description'
    ];

    /**
     * Get setting value by key
     */
    public static function getValue($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set or update setting value
     */
    public static function setValue($key, $value, $type = 'text', $description = null)
    {
        return self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'description' => $description,
            ]
        );
    }

    /**
     * Get all license page settings
     */
    public static function getLicenseSettings()
    {
        return [
            'license_title' => self::getValue('license_title', 'Lisensi LSP Pasar Modal'),
            'license_description' => self::getValue('license_description', 'Sertifikasi kompetensi kerja bidang pasar modal pertama di Indonesia dilaksanakan oleh Lembaga Sertifikasi Profesi Pasar Modal (LSP-PM) yang telah memperoleh lisensi dari BNSP sebagai berikut:')
        ];
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
