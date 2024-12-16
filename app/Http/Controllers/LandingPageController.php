<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $locations = Location::with('category')->get();

        // Konversi koordinat dari JSON string ke array
        $locations->transform(function ($location) {
            $location->coords = json_decode($location->coords, true); // Pastikan koordinat berupa array
            return $location;
        });

        return view('landing', compact('categories', 'locations'));
    }
}
