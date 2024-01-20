<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class User extends Controller
{
    public function getUsers(){
        return response()->json([
            'users' => \App\Models\User::all(),
            'products' => Product::all(),
        ]);
    }
}
