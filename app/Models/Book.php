<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // Allow mass assignment for these fields
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'category',
        'quantity',
        'available'
    ];

    // Relationship: A book can be borrowed multiple times
    public function borrowedBooks()
    {
        return $this->hasMany(BorrowedBook::class);
    }
}
