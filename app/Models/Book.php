<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'author',
        'title',
        'category',
        'current_count',
        'total_count'
    ];

    public function transaction(){
        return $this->hasMany(Transaction::class);
    }
}
