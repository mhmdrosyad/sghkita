<?php

namespace App\Http\Controllers;

use App\Imports\CategoriesImport;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    protected $categoryModel;

    public function __construct(Category $category)
    {
        $this->categoryModel = $category;
    }

    public function index()
    {
        $categories = $this->categoryModel->with(['debitAccount', 'creditAccount'])->get();
        return view('category.index', compact('categories'));
    }

    public function add()
    {
        $accounts = Account::all();
        return view('category.add', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:categories,code',
            'name' => 'required|string|max:255',
            'type' => 'required|in:in,out,mutation',
            'debet' => 'required|exists:accounts,code',
            'credit' => 'required|exists:accounts,code',
        ]);

        $this->categoryModel->create([
            'code' => $request->code,
            'name' => $request->name,
            'type' => $request->type,
            'debit_account_code' => $request->debet,
            'credit_account_code' => $request->credit,
            'note' => $request->note,
        ]);

        return redirect()->route('category.index')->with('success', 'Category created successfully.');
    }

    public function edit($code)
    {
        $category = Category::where('code', $code)->firstOrFail();
        $accounts = Account::all();
        return view('category.edit', compact('accounts', 'category'));
    }

    public function update(Request $request, $code)
    {
        $category = Category::where('code', $code)->firstOrFail();
        $category->update($request->all());
        return redirect()->route('category.index')->with('success', 'Account updated successfully');
    }

    public function destroy($code)
    {
        $category = Category::where('code', $code)->firstOrFail();
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Account deleted successfully');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        DB::beginTransaction();

        try {
            $import = new CategoriesImport;
            Excel::import($import, $request->file('file'));

            DB::commit();
            return redirect()->back()->with('success', 'Categories imported successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'There was an error importing the categories: ' . $e->getMessage());
        }
    }
}
