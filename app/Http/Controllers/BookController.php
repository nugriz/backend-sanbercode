<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return Book::all();
    }

    public function store(Request $request)
    {
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