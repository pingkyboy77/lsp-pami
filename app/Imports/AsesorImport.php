<?php

namespace App\Imports;

use App\Models\Asesor;
use Maatwebsite\Excel\Concerns\ToModel;

class AsesorImport implements ToModel
{
    public function model(array $row)
    {
        if ($row[0] === 'Nama') return null;

        return new Asesor([
            'nama' => $row[0],
            'nomor_met' => $row[1],
        ]);
    }
}

