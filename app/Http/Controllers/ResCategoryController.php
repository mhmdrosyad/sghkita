<?php

namespace App\Http\Controllers;

use App\Models\ResCategory;
use Illuminate\Http\Request;

class ResCategoryController extends Controller
{
    public function index()
    {
        $categories = ResCategory::all();
        return view('reservation.category', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'note' => 'nullable|string',
        ]);

        ResCategory::create($request->all());

        return redirect()->route('res_category.index')->with('success', 'Category created successfully.');
    }

    public function update(Request $request, ResCategory $resCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'note' => 'nullable|string',
        ]);

        $resCategory->update($request->all());

        return redirect()->route('res_category.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(ResCategory $resCategory)
    {
        $resCategory->delete();

        return redirect()->route('res_category.index')->with('success', 'Category deleted successfully.');
    }
}
