<?php

namespace App\Http\Controllers;

use App\Models\Marker;
use Illuminate\Http\Request;

class MarkerController extends Controller
{
    // Fetch all markers
    public function index()
    {
        return response()->json(Marker::all());
    }

    // Store a new marker
    public function store(Request $request)
    {
        $marker = Marker::create([
            'name' => $request->name,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json($marker, 201);
    }

    // Update an existing marker
    public function update(Request $request, $id)
    {
        $marker = Marker::findOrFail($id);
        $marker->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json($marker);
    }

    // Delete a marker
    public function destroy($id)
    {
        $marker = Marker::findOrFail($id);
        $marker->delete();

        return response()->json(['message' => 'Marker deleted']);
    }
}