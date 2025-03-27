<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::with('products')->paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'logo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('brands', 'public');
        }

        $validated['slug'] = Str::slug($validated['name']);
        $brand = Brand::create($validated);

        return redirect()->route('admin.brands.index')->with('success', "Brand <b>{$brand->name}</b> created successfully.");
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.form', compact('brand'));
    }

    public function update(Request $request, Brand $brand): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'logo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('brands', 'public');
        }

        $validated['slug'] = Str::slug($validated['name']);
        $brand->update($validated);

        return redirect()->route('admin.brands.index')->with('success', "Brand <b>{$brand->name}</b> updated successfully.");
    }

    public function destroy(Brand $brand): RedirectResponse
    {
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', "Brand <b>{$brand->name}</b> deleted successfully.");
    }
}
