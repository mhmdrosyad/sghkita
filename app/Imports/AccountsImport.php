<?php

namespace App\Imports;

use App\Models\Account;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AccountsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $position = strtolower($row['position']);
        if (!in_array($position, ['activa', 'passiva', 'income', 'outcome'])) {
            throw new \Exception("Invalid position value: " . $row['position']);
        }

        return new Account([
            'code' => $row['code'],
            'name' => $row['name'],
            'position' => $position,
        ]);
    }
}
