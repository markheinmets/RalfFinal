<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyFavoriteSubject extends Model
{
    use HasFactory;

        protected $table = 'my_favorite_subject';

        protected $fillable = ['title', 'description', 'image', 'category', 'rating'];

}
