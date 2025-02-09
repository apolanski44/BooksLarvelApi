<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function store(Request $req) {
        $req->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1800|max:' . date('Y'),
            'description' => 'nullable|string',
        ]);

        $book = Book::create($req->all());
        return response()->json($book, 201);
    }
    public function index(Request $req) {
        $query = Book::query();

        if ($req->has('sort_by')) {
            $allowedSorts = ['title', 'author', 'publication_year'];
            if (in_array($req->sort_by, $allowedSorts)) {
                $query->orderBy($req->sort_by);
            }
        }
        return response()->json($query->get());
    }
    public function show($id) {
        $book = Book::findOrFail($id);
        return response()->json($book);
    }
    
}
