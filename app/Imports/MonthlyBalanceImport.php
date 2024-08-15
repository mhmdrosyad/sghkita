<?php

namespace App\Imports;

use App\Models\Account;
use App\Models\MonthlyBalance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MonthlyBalanceImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        try {
            $account = Account::where('code', $row['kode'])->first();
            if (!$account) {
                throw new \Exception("Invalid credit account code: " . $row['kode']);
            }

            $month = Carbon::createFromFormat('m-Y', '01-2024');
            $balance = floatval($row['saldo']);
            $formattedBalance = number_format($balance, 2, '.', '');

            $account->current_balance = $formattedBalance;
            $account->save();
            return new MonthlyBalance([
                'account_code' => $row['kode'],
                'month' => $month->format('m-Y'),
                'balance' => $formattedBalance,
            ]);
        } catch (\Exception $e) {
            Log::error("Error processing row: " . json_encode($row) . " Exception: " . $e->getMessage());
            return null;
        }
    }
}
