<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Custom\ListingController;

// Primer override rute
Route::get('/listing/{slug}', [ListingController::class, 'show']);
