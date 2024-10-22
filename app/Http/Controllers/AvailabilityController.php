<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index()
    {
        $availabilities = Availability::all();

        return view('availabilities.index', compact('availabilities'));
    }


    public function create()
    {
        return view('availabilities.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:availabilities|max:255',
        ]);

        Availability::create($request->all());

        return redirect()->route('availabilities.index')
            ->with('success', 'Availability created successfully.');
    }


    public function show(Availability $availability)
    {
        return view('availabilities.show', compact('availability'));
    }

    public function edit(Availability $availability)
    {
        return view('availabilities.edit', compact('availability'));
    }

    public function update(Request $request, Availability $availability)
    {
        $request->validate([
            'name' => 'required|unique:availabilities,name,' . $availability->id . '|max:255',
        ]);

        if ($availability->update($request->all())) {
            return redirect()->route('availabilities.index')
                ->with('success', 'Availability updated successfully.');
        } else {
            return redirect()->route('availabilities.index')
                ->with('error', 'Failed to update availability.');
        }
    }

    public function destroy(Availability $availability)
    {
        if ($availability->delete()) {
            return redirect()->route('availabilities.index')
                ->with('success', 'Availability deleted successfully.');
        } else {
            return redirect()->route('availabilities.index')
                ->with('error', 'Failed to delete availability.');
        }
    }
}
