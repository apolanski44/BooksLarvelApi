<?php

namespace App\Http\Controllers;
use App\Models\Review;
use App\Models\Book;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $req, $book_id){
        $req->validate([
            'username' => 'required|string|max:50',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string',
        ]);

        $book = Book::findOrFail($book_id);

        $review = $book->reviews()->create([
            'user_id' => auth()->id(),
            'username' => $req->username,
            'rating' => $req->rating,
            'content' => $req->content,
        ]);

        return response()->json($review, 201);
    }

    public function index(Request $req, $book_id) {

        $query = Review::where('book_id', $book_id);
        if ($req->has('rating') && in_array($req->rating, [1, 2, 3, 4, 5])) {
            $query->where('rating', $req->rating);
        }
    
        $reviews = $query->orderBy('rating', 'desc')->get();
        return response()->json($reviews);
    }

    public function update(Request $req, $id) {
        $review = Review::findOrFail($id);

        if (auth()->id() !== $review->user_id) {
            return response()->json(['error' => 'Brak uprawnień'], 403);
        }

        $req->validate([
            'rating' => 'integer|min:1|max:5',
            'content' => 'string',
        ]);

        $review->update($req->only(['rating', 'content']));

        return response()->json($review);
    }

    public function delete($id) {
        $review = Review::findOrFail($id);

        if (auth()->id() !== $review->user_id) {
            return response()->json(['error' => 'Brak uprawnień'], 403);
        }

        $review->delete();
        return response()->json(['message' => 'Recenzja usunięta']);
    }
    public function show($id) {
        $review = Review::findOrFail($id);
        
        if (auth()->id() !== $review->user_id) {
            return response()->json(['error' => 'Brak uprawnień'], 403);
        }
    
        return response()->json($review);
    }
    


}
