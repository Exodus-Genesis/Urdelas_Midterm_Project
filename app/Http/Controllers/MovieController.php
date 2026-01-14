<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Http\Request;
use Dompdf\Dompdf;

class MovieController extends Controller
{
    // Display dashboard
    public function index(Request $request)
    {
        $query = Movie::with('genre');

        // Search by title or director
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('director', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by genre
        if ($request->filled('genre_filter')) {
            $query->where('genre_id', $request->genre_filter);
        }

        $movies = $query->latest()->get();
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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('Movie-photo', 'public');
        }

        $rating = $request->input('rating');

        // Convert "8/10" style ratings to numeric
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
            'photo' => $photoPath,
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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle photo upload and delete old if exists
        $photoPath = $movie->photo; // keep current if not updating
        if ($request->hasFile('photo')) {
            if ($movie->photo) {
                Storage::disk('public')->delete($movie->photo);
            }
            $photoPath = $request->file('photo')->store('Movie-photo', 'public');
        }

        $rating = $request->input('rating');

        // Convert "8/10" style ratings to numeric
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
            'photo' => $photoPath,
        ]);

        return redirect()->back()->with('success', 'Game updated successfully!');
    }

    // Delete a movie
    public function destroy(Movie $movie)
    {

        $movie->delete();
        return redirect()->back()->with('success', 'Game Moved to recycle Bin!');
    }
    
public function trash()
{
    $movies = Movie::onlyTrashed()->with('genre')->latest('deleted_at')->get();
    $genres = genre::all();

    return view('trash', compact('movies', 'genres'));
}

public function restore($id)
{
    $movie = Movie::withTrashed()->findOrFail($id);
    $movie->restore();

    return redirect()->route('movies.trash')->with('success', 'Game restored successfully.');
}

public function forceDelete($id)
{
    $movie = Movie::withTrashed()->findOrFail($id);

    if ($movie->photo) {
        Storage::disk('public')->delete($movie->photo);
    }

    $movie->forceDelete();

    return redirect()->route('movies.trash')->with('success', 'Game permanently deleted.');
}


public function export(Request $request)
{
    $query = Movie::with('genre');

    if ($request->filled('search')) {
        $searchTerm = $request->search;
        $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'like', "%{$searchTerm}%")
              ->orWhere('description', 'like', "%{$searchTerm}%");
        });
    }

    if ($request->filled('genre_filter') && $request->genre_filter != '') {
        $query->where('genre_id', $request->genre_filter);
    }

    $movies = $query->latest()->get();

    $filename = 'games_export_' . date('Y-m-d_His') . '.pdf';

    $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Game Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 10px;
        }

        .export-info {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Games List</h1>
    <div class="export-info">
        Generated on ' . date('F d, Y h:i A') . '
    </div>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Genre</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($movies as $movie) {
        $html .= '<tr>
            <td>' . $movie->title . '</td>
            <td>' . $movie->description . '</td>
            <td>' . optional($movie->genre)->name . '</td>
        </tr>';
    }

    $html .= '</tbody>
    </table>
</div>
</body>
</html>';

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    return $dompdf->stream($filename, ['Attachment' => true]);
}


}
