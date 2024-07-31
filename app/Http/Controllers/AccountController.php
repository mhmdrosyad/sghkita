<?php

namespace App\Http\Controllers;

use App\Imports\AccountsImport;
use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AccountController extends Controller
{
    protected $accountModel;

    public function __construct(Account $accountModel)
    {
        $this->accountModel = $accountModel;
    }

    public function index()
    {
        $accounts = $this->accountModel->all();
        $totalInitialBalance = $accounts->sum('initial_balance');
        return view('account.index', compact('accounts', 'totalInitialBalance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:accounts,code',
            'name' => 'required|string|max:255',
            'position' => 'required|in:asset,liability,revenue,expense',
        ]);

        $this->accountModel->create([
            'code' => $request->code,
            'name' => $request->name,
            'position' => $request->position,
        ]);

        return redirect()->route('account.index')->with('success', 'Account created successfully.');
    }

    public function edit($code)
    {
        $account = Account::where('code', $code)->firstOrFail();
        return view('account.edit', compact('account'));
    }

    public function update(Request $request, $code)
    {
        $account = Account::where('code', $code)->firstOrFail();
        $account->update($request->all());
        return redirect()->route('account.index')->with('success', 'Account updated successfully');
    }

    public function destroy($code)
    {
        $account = Account::where('code', $code)->firstOrFail();
        $account->delete();
        return redirect()->route('account.index')->with('success', 'Account deleted successfully');
    }

    public function addInitialBalance(Request $request, $accountCode)
    {
        $validator = Validator::make($request->all(), [
            'initial_balance' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $account = Account::where('code', $accountCode)->firstOrFail();

        $account->update([
            'initial_balance' => $request->input('initial_balance'),
            'current_balance' => $request->input('initial_balance'),
        ]);

        return redirect()->route('account.index')->with('success', 'Initial balance added successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new AccountsImport, $request->file('file'));
            return redirect()->back()->with('success', 'Accounts imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'There was an error importing the accounts: ' . $e->getMessage());
        }
    }

    public function inputBalance()
    {
        $accounts = $this->accountModel->all();
        return view('account.input-balance', compact('accounts'));
    }

    public function storeInitialBalance(Request $request)
    {
        $accountBalances = $request->input('account', []);

        $totalActiva = 0;
        $totalPassiva = 0;

        foreach ($accountBalances as $code => $balance) {
            $account = Account::where('code', $code)->first();
            if ($account) {
                if ($account->position == 'activa') {
                    $totalActiva += (float) $balance;
                } elseif ($account->position == 'passiva') {
                    $totalPassiva += (float) $balance;
                }
            }
        }


        if ($totalActiva !== $totalPassiva) {
            return redirect()->back()->withErrors(['Saldo tidak sama antara Activa dan Passiva'])->withInput();
        }

        foreach ($accountBalances as $code => $balance) {
            $account = Account::where('code', $code)->first();
            if ($account) {
                $account->initial_balance = is_null($balance) ? 0 : (float) $balance;
                $account->current_balance = is_null($balance) ? 0 : (float) $balance;
                $account->save();
            }
        }

        return redirect()->route('account.index')->with('success', 'Saldo awal berhasil disimpan.');
    }
}
