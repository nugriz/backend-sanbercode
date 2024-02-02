<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Book;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function show(Request $request, $id)
    {
        $category = Category::find($id);
        $books = Book::all()->where('category_id', $category->id);
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

        return response()->json([
            'category' => $category,
            'books' => $books
        ], 201);
    }

    public function store(Request $request)
    {
        $category = Category::create($request->all());

        return response()->json($category, 201);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->all());

        return response()->json($category, 200);
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(null, 204);
    }
}