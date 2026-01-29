<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalBooks = Book::sum('quantity');
        $totalUsers = User::where('role', 'user')->count();
        $totalBorrowed = \App\Models\BorrowedBook::where('status', 'borrowed')->count();

        return response()->json([
            'totalBooks' => $totalBooks,
            'totalUsers' => $totalUsers,
            'totalBorrowed' => $totalBorrowed
        ]);
    }

    public function manageBooks()
    {
        $books = Book::all();
        return response()->json($books);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        $book = Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'category' => $request->category,
            'quantity' => $request->quantity,
            'available' => $request->quantity,
        ]);

        return response()->json([
            'message' => 'Book added successfully!',
            'book' => $book
        ], 201);
    }

    public function getStudents()
    {
        $students = User::where('role', 'user')->get();
        return response()->json($students);
    }

    public function getIssuedBooks()
    {
        $issued = \App\Models\BorrowedBook::with(['book', 'user'])->get();
        return response()->json($issued);
    }
}
