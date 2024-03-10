<?php

namespace App\Http\Controllers\Bike;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Bike;
class BikeController extends Controller
{
    /**
     * Display a listing of bikes.
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $bikes = Bike::all();
        return view('shop', compact('bikes'));
    }

    /**
     * Show the form for creating a new bike.
     */
    public function create(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('bikes.create');
    }

    /**
     * Store a newly created bike in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            // 'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Jeśli chcesz przesłać obrazek
        ]);

        $bike = Bike::create($validatedData);
        return redirect()->route('bikes.index')->with('success', 'Bike added successfully');
    }

    /**
     * Display the specified bike.
     */
    public function show(string $id): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $bike = Bike::findOrFail($id);
        return view('bikes.show', compact('bike'));
    }

    /**
     * Show the form for editing the specified bike.
     */
    public function edit(string $id): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $bike = Bike::findOrFail($id);
        return view('bikes.edit', compact('bike'));
    }

    /**
     * Update the specified bike in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            // 'image_path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Jeśli chcesz zaktualizować obrazek
        ]);

        $bike = Bike::findOrFail($id);
        $bike->update($validatedData);
        return redirect()->route('bikes.index')->with('success', 'Bike updated successfully');
    }

    /**
     * Remove the specified bike from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $bike = Bike::findOrFail($id);
        $bike->delete();
        return redirect()->route('bikes.index')->with('success', 'Bike deleted successfully');
    }
}
