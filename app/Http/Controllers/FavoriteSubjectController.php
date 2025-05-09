<?php

namespace App\Http\Controllers;

use App\Models\MyFavoriteSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class FavoriteSubjectController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string',
            'category' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $subject = MyFavoriteSubject::create($validated);

        Cache::forget('favorite_subjects'); // clear cache

        return redirect()->back()->with('success', 'Subject added!');
    }

    public function api(Request $request)
    {
        $limit = $request->input('limit', 10);

        $subjects = Cache::remember('favorite_subjects', 60, function () use ($limit) {
            return MyFavoriteSubject::latest()->take($limit)->get();
        });

        return response()->json($subjects);
    }

    public function index()
    {
        $response = Http::get('https://hajus.tak23mand.itmajakas.ee/api/favourite/07b4cc44-9042-4944-b1dc-56eac757ca4f');

        $subjects = MyFavoriteSubject::latest()->get();
        return inertia('Subjects/Index', [
            'subjects' => $subjects,
            'apiData' => $response->json(),
        ]);
    }
}
