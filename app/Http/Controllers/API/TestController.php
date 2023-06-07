<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index() {
        return response()->json([
            'id' => 1,
            'username' => 'Abigail',
            'email' => 'test@gmail.com'
        ]);
    }
}
