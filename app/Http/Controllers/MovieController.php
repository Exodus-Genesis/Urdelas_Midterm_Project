<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    // Display dashboard
    public function index()
    {
        $movies = Movie::with('genre')->get();
        $genres = Genre::all();
        $totalMovies = Movie::count();
        $totalGenres = Genre::count();
        $topRated = Movie::orderBy('rating', 'desc')->first();

        return view('dashboard', compact('movies', 'genres', 'totalMovies', 'totalGenres', 'topRated'));
    }

    // Store a new movie
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:movies,title',
            'director' => 'required|string|max:255',
            'release_year' => 'required|digits:4|integer',
            'rating' => 'nullable|string', // allow numeric or "8/10"
            'genre_id' => 'nullable|exists:genres,id',
            'description' => 'nullable|string',
        ]);

        $rating = $request->input('rating');

        // Convert "8/10" style ratings
        if ($rating && str_contains($rating, '/')) {
            [$num, $den] = explode('/', $rating);
            $rating = floatval($num) / floatval($den) * 10;
        }

        Movie::create([
            'title' => $request->title,
            'director' => $request->director,
            'release_year' => $request->release_year,
            'genre_id' => $request->genre_id,
            'rating' => $rating,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Game created successfully!');
    }

    // Update an existing movie
    public function update(Request $request, Movie $movie)
    {
        $request->validate([
            'title' => 'required|unique:movies,title,' . $movie->id,
            'director' => 'required|string|max:255',
            'release_year' => 'required|digits:4|integer',
            'rating' => 'nullable|string', // numeric or "8/10"
            'genre_id' => 'nullable|exists:genres,id',
            'description' => 'nullable|string',
        ]);

        $rating = $request->input('rating');

        // Convert "8/10" style ratings
        if ($rating && str_contains($rating, '/')) {
            [$num, $den] = explode('/', $rating);
            $rating = floatval($num) / floatval($den) * 10;
        }

        $movie->update([
            'title' => $request->title,
            'director' => $request->director,
            'release_year' => $request->release_year,
            'genre_id' => $request->genre_id,
            'rating' => $rating,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Game updated successfully!');
    }

    // Delete a movie
    public function destroy(Movie $movie)
    {
        $movie->delete();
        return redirect()->back()->with('success', 'Game deleted successfully!');
    }
}
