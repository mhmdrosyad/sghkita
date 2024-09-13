<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Cek apakah kolom 'nama' tidak kosong, karena 'name' adalah kolom yang wajib
        if (!isset($row['nama']) || empty($row['nama'])) {
            return null; // Lewatkan baris jika kolom 'name' kosong
        }

        // Lakukan insert ke database jika semua data ada
        return new Customer([
            'name'     => $row['nama'],      // Sesuaikan dengan nama header di Excel
            'agency'   => $row['agency'],    // Pastikan header sesuai
            'no_hp'    => $row['no_hp'],   // Sesuaikan dengan kolom No HP.1
            'no_hp_alt' => $row['no_hp_2'],  // Sesuaikan dengan kolom No HP.2
        ]);
    }
}
