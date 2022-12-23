<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class book_userInfo extends Model
{
    protected $table = 'book_user_info';

    protected $fillable = [
        'usersid',
        'bookId',
    ];

    use HasFactory;
}
