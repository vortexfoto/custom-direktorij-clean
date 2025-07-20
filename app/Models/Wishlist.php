<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    // Specify the fields that are mass assignable
    protected $fillable = [
        'listing_id',
        'type',
        'user_id',
    ];
}
