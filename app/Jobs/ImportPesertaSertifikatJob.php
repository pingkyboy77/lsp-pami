<?php
namespace App\Jobs;

use App\Imports\AsesorImport;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use App\Imports\PesertaSertifikatImport;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportPesertaSertifikatJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function import(Request $request)
    {
        Excel::import(new AsesorImport(), $request->file('file'));

        return back()->with('success', 'Import sukses');
    }
}
