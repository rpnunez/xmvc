<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Response;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return new Response("Welcome to your profile!");
    }
}