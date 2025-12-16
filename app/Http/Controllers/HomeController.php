<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Response;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return new Response(view('home.welcome', ['name' => 'XMVC User']));
    }
}