<?php

namespace App\Http\Controllers;

use App\Models\Rice;
use Illuminate\Http\Request;

class RiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rices = Rice::all();
        return view('rice.index', compact('rices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rice.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price_per_kg' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        Rice::create($validated);

        return redirect()->route('rice.index')->with('success', 'Rice item added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rice $rice)
    {
        return view('rice.show', compact('rice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rice $rice)
    {
        return view('rice.edit', compact('rice'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rice $rice)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price_per_kg' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $rice->update($validated);

        return redirect()->route('rice.index')->with('success', 'Rice item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rice $rice)
    {
        $rice->delete();
        return redirect()->route('rice.index')->with('success', 'Rice item deleted successfully!');
    }
}
