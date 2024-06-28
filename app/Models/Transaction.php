<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
use App\Models\User;


class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_at',
        'return_date'
    ];

    public function users(){
       return $this->belongsTo(User::class);
    }
    public function books(){
        return $this->belongsTo(Book::class);
    }
  
}
