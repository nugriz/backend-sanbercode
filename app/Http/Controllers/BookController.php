<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::all();
        if ($request->query('title')) {
            $books = $books->where('title', 'like', $request->query('title'));
        }

        if ($request->query('sortByTitle')) {
            $books = $request->query('sortByTitle') == 'asc' ? $books->sortBy('title') : $books->sortByDesc('title');
        }

        if ($request->query('minYear')) {
            $books = $books->where('release_year', '>=', $request->query('minYear'));
        }

        if ($request->query('maxYear')) {
            $books = $books->where('release_year', '<=', $request->query('maxYear'));
        }

        if ($request->query('minPage')) {
            $books = $books->where('total_page', '>=', $request->query('minPage'));
        }

        if ($request->query('maxPage')) {
            $books = $books->where('total_page', '<=', $request->query('maxPage'));
        }

        return response()->json($books, 201);
    }

    public function store(Request $request)
    {
        if ($request->release_year < 1980 || $request->release_year > 2021) {
            return response()->json(['message'=> 'tahun rilis tidak valid'], 400);
        }

        if ($request->total_page <= 100) {
            $request['thickness'] = 'tipis';
        } elseif ($request->total_page > 100 && $request->total_page <= 200) {
            $request['thickness'] = 'sedang';
        } else {
            $request['thickness'] = 'tebal';
        }
        
        $book = Book::create($request->all());

        return response()->json($book, 201);
    }

    public function update(Request $request, $id)
    {
        if ($request->release_year < 1980 || $request->release_year > 2021) {
            return response()->json(['message'=> 'tahun rilis salah'], 400);
        }

        if ($request->total_page <= 100) {
            $request['thickness'] = 'tipis';
        } elseif ($request->total_page > 100 && $request->total_page <= 200) {
            $request['thickness'] = 'sedang';
        } else {
            $request['thickness'] = 'tebal';
        }

        $book = Book::findOrFail($id);
        $book->update($request->all());

        return response()->json($book, 200);
    }

    public function delete($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json(null, 204);
    }
}