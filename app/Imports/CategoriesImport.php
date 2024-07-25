<?php

namespace App\Imports;

use App\Models\Account;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoriesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $type = strtolower($row['type']);

        if (!in_array($type, ['in', 'out', 'mutation'])) {
            throw new \Exception("Invalid type value: " . $row['type']);
        }

        $debetAccount = Account::where('code', $row['debet'])->first();
        if (!$debetAccount) {
            throw new \Exception("Invalid debet account code: " . $row['debet']);
        }

        $creditAccount = Account::where('code', $row['credit'])->first();
        if (!$creditAccount) {
            throw new \Exception("Invalid credit account code: " . $row['credit']);
        }

        return new Category([
            'code' => $row['code'],
            'type' => $type,
            'name' => $row['name'],
            'debet' => $debetAccount->code,
            'credit' => $creditAccount->code,
        ]);
    }
}
