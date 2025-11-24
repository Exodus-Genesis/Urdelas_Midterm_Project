<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    // Display all genres with movies count
    public function index()
    {
        // Load genres with movie counts
        $genres = Genre::withCount('movies')->get();

        // Total number of genres
        $totalGenres = $genres->count();

        // Genre with the most movies (or null if none)
        $topGenre = $genres->sortByDesc('movies_count')->first();

        // Sum of all movies across genres
        $totalMoviesAcrossGenres = $genres->sum('movies_count');

        return view('genres', compact(
            'genres',
            'totalGenres',
            'topGenre',
            'totalMoviesAcrossGenres'
        ));
    }

    // Store a new genre
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:genres,name',
            'description' => 'nullable|string|max:1000',
        ]);

        Genre::create($request->only(['name', 'description']));

        return redirect()->back()->with('success', 'Genre created successfully!');
    }

    // Update an existing genre
    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,' . $genre->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $genre->update($request->only(['name', 'description']));

        return redirect()->back()->with('success', 'Game Genre updated successfully!');
    }

    // Delete a genre and detach it from movies
    public function destroy(Genre $genre)
    {
        // Set genre_id of associated movies to null before deleting
        $genre->movies()->update(['genre_id' => null]);

        $genre->delete();

        return redirect()->back()->with('success', 'Game Genre deleted successfully!');
    }
}
