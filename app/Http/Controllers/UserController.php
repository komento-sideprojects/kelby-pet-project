<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowedBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'User dashboard data here']);
    }

    public function browse()
    {
        $books = Book::where('available', '>', 0)->get();
        return response()->json($books);
    }

    public function borrow(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::find($request->book_id);

        if ($book->available > 0) {
            $book->decrement('available');

            $borrowed = BorrowedBook::create([
                'user_id' => Auth::id(),
                'book_id' => $book->id,
                'borrow_date' => now()->toDateString(),
                'due_date' => now()->addDays(14)->toDateString(),
                'status' => 'borrowed'
            ]);

            return response()->json([
                'message' => 'Book borrowed successfully!',
                'borrowed' => $borrowed
            ]);
        }

        return response()->json(['message' => 'Book is not available.'], 400);
    }

    public function borrowed()
    {
        $borrowedBooks = Auth::user()->borrowedBooks()->with('book')->get();
        return response()->json($borrowedBooks);
    }
}
