<?php

namespace App\Imports;

use App\Models\Account;
use App\Models\Category;
use App\Models\LedgerEntry;
use App\Models\MonthlyBalance;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TransactionsImport implements ToModel, WithHeadingRow
{
    private function updateMonthlyBalance(Account $account, $transactionMonth, $nominal)
    {
        try {
            $currentMonthFormatted = Carbon::createFromFormat('m-Y', $transactionMonth);

            $monthlyBalance = MonthlyBalance::where('account_code', $account->code)
                ->where('month', $transactionMonth)
                ->first();

            if ($monthlyBalance) {
                $monthlyBalance->balance += $nominal;
            } else {
                $previousMonth = $currentMonthFormatted->copy()->subMonth()->format('m-Y');
                $previousMonthlyBalance = MonthlyBalance::where('account_code', $account->code)
                    ->where('month', $previousMonth)
                    ->first();

                $initialBalance = $previousMonthlyBalance ? $previousMonthlyBalance->balance : $account->initial_balance;

                $monthlyBalance = new MonthlyBalance();
                $monthlyBalance->account_code = $account->code;
                $monthlyBalance->month = $transactionMonth;
                $monthlyBalance->balance = $initialBalance + $nominal;
            }

            $monthlyBalance->save();
        } catch (Exception $e) {
            dd('Error updating monthly balance: ' . $e->getMessage(), ['account_code' => $account->code, 'transactionMonth' => $transactionMonth, 'nominal' => $nominal]);
        }
    }

    private function updateRevenueAccount($amount, $type, $transactionMonth)
    {
        try {
            $revenueAccount = Account::where('code', '305')->first();

            if (!$revenueAccount) {
                return;
            }

            if ($type == 'revenue') {
                $revenueAccount->current_balance += $amount;
            } elseif ($type == 'expense') {
                $revenueAccount->current_balance -= $amount;
            }

            $revenueAccount->save();
            $this->updateMonthlyBalance($revenueAccount, $transactionMonth, $amount * ($type == 'expense' ? -1 : 1));
        } catch (Exception $e) {
            dd('Error updating revenue account: ' . $e->getMessage(), ['amount' => $amount, 'type' => $type, 'transactionMonth' => $transactionMonth]);
        }
    }

    public function model(array $row)
    {
        try {
            $category = Category::where('code', $row['kode'])->first();
            if (!$category) {
                dd('Invalid category code: ' . $row['kode']);
            }

            $debetAccount = $category->debitAccount;
            $creditAccount = $category->creditAccount;

            $transactionDate = Carbon::createFromFormat('d/m/Y', $row['tanggal'])->startOfDay();
            $transactionMonth = $transactionDate->format('m-Y');

            $transaction = Transaction::create([
                'transaction_at' => $transactionDate,
                'description' => $row['keterangan'],
                'category_code' => $row['kode'],
                'nominal' => $row['nominal'],
                'user_id' => Auth::id(),
            ]);

            if (!$transaction || !$transaction->id) {
                dd('Failed to create transaction', ['row' => $row]);
            }

            if ($debetAccount) {
                try {
                    if ($debetAccount->position == 'asset') {
                        $debetAccount->current_balance += $row['nominal'];
                        $this->updateMonthlyBalance($debetAccount, $transactionMonth, $row['nominal']);
                    } elseif ($debetAccount->position == 'liability') {
                        $debetAccount->current_balance -= $row['nominal'];
                        $this->updateMonthlyBalance($debetAccount, $transactionMonth, -$row['nominal']);
                    } else {
                        $debetAccount->current_balance += $row['nominal'];
                        $this->updateMonthlyBalance($debetAccount, $transactionMonth, $row['nominal']);
                        $this->updateRevenueAccount($row['nominal'], $debetAccount->position, $transactionMonth);
                    }
                    $debetAccount->save();

                    LedgerEntry::create([
                        'transaction_id' => $transaction->id,
                        'account_code' => $debetAccount->code,
                        'entry_date' => $transaction->transaction_at,
                        'entry_type' => 'debit',
                        'amount' => $row['nominal'],
                    ]);
                } catch (Exception $e) {
                    dd('Error creating debit ledger entry: ' . $e->getMessage(), ['transaction_id' => $transaction->id, 'account_code' => $debetAccount->code, 'entry_date' => $transaction->transaction_at, 'amount' => $row['nominal']]);
                }
            }

            if ($creditAccount) {
                try {
                    if ($creditAccount->position == 'asset') {
                        $creditAccount->current_balance -= $row['nominal'];
                        $this->updateMonthlyBalance($creditAccount, $transactionMonth, -$row['nominal']);
                    } elseif ($creditAccount->position == 'liability') {
                        $creditAccount->current_balance += $row['nominal'];
                        $this->updateMonthlyBalance($creditAccount, $transactionMonth, $row['nominal']);
                    } else {
                        $creditAccount->current_balance += $row['nominal'];
                        $this->updateMonthlyBalance($creditAccount, $transactionMonth, $row['nominal']);
                        $this->updateRevenueAccount($row['nominal'], $creditAccount->position, $transactionMonth);
                    }
                    $creditAccount->save();

                    LedgerEntry::create([
                        'transaction_id' => $transaction->id,
                        'account_code' => $creditAccount->code,
                        'entry_date' => $transaction->transaction_at,
                        'entry_type' => 'credit',
                        'amount' => $row['nominal'],
                    ]);
                } catch (Exception $e) {
                    dd('Error creating credit ledger entry: ' . $e->getMessage(), ['transaction_id' => $transaction->id, 'account_code' => $creditAccount->code, 'entry_date' => $transaction->transaction_at, 'amount' => $row['nominal']]);
                }
            }

            return $transaction;
        } catch (Exception $e) {
            dd('Error importing transaction: ' . $e->getMessage(), ['row' => $row]);
        }
    }
}
