<?php

namespace App\Imports;

use App\Models\PesertaSertifikat;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class PesertaSertifikatImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            if ($index === 0) {
                continue;
            } // Skip header
            if ($row->filter()->isEmpty()) {
                continue;
            } // Skip empty rows

            $nama = $row[0] ?? null;

            PesertaSertifikat::upsert(
                [
                    [
                        'nama' => $nama,
                        'sertifikasi' => $row[1] ?? null,
                        'no_ser' => $row[2] ?? null,
                        'no_reg' => $row[3] ?? null,
                        'no_sertifikat' => $row[4] ?? null,
                        'tanggal_terbit' => $this->parseExcelDate($row[5] ?? null),
                        'tanggal_exp' => $this->parseExcelDate($row[6] ?? null),
                        'registrasi_nomor' => $row[7] ?? null,
                        'tahun_registrasi' => $row[8] ?? null,
                        'nomor_blanko' => $row[9] ?? null,
                    ],
                ],
                ['no_sertifikat'], // kunci unik untuk mendeteksi duplikat
                ['nama', 'sertifikasi', 'no_ser', 'no_reg', 'tanggal_terbit', 'tanggal_exp', 'registrasi_nomor', 'tahun_registrasi', 'nomor_blanko'],
            );
        }
    }

    private function parseExcelDate($value)
    {
        try {
            if (!$value) {
                return null;
            }
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            }
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
