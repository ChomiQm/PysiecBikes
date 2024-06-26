<?php

namespace App\Http\Controllers\UserData;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use App\Models\UserData;
use Illuminate\Http\RedirectResponse;

class UserDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $userData = auth()->user()->userData;
        return view('user.user_data', compact('userData'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'country' => 'required|max:255',
            'state' => 'required|max:255',
            'city' => 'required|max:255',
            'street_address' => 'required|max:255',
            'postal_code' => 'required|max:255',
        ]);

        UserData::create($validatedData);
        return redirect()->route('user.user_data')->with('success', 'User data created successfully');
    }

    /**
     * Display the specified resource.
     */

    public function show(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $userData = UserData::findOrFail($id);
        return view('user.user_data', compact('userData'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $userData = UserData::findOrFail($id);
        return view('user.user_data', compact('userData'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'country' => 'required|max:255',
            'state' => 'required|max:255',
            'city' => 'required|max:255',
            'street_address' => 'required|max:255',
            'postal_code' => 'required|max:255',
        ]);

        $userData = UserData::findOrFail($id);
        $userData->update($validatedData);

        return response()->json([
            'message' => 'Dane zostały zaktualizowane pomyślnie.',
            'data' => $userData
        ]);
    }


}
