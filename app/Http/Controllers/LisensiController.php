<?php

namespace App\Http\Controllers;

use App\Models\License;
use Illuminate\Http\Request;
use App\Models\LicenseSetting;

class LisensiController extends Controller
{
    public function index()
    {
        // Get license page settings
        $licenseSettings = LicenseSetting::getLicenseSettings();
        
        // Get active licenses ordered by order field
        $licenses = License::getActiveLicenses()->map(function ($license) {
            return [
                'image' => $license->image,
                'title' => $license->title,
                'subtitle' => $license->subtitle,
                'desc1' => $license->desc1,
                'desc2' => $license->desc2,
            ];
        })->toArray();

        return view('page.lisensi.index', [
            'license_title' => $licenseSettings['license_title'],
            'license_description' => $licenseSettings['license_description'],
            'licenses' => $licenses,
        ]);
    }
}
