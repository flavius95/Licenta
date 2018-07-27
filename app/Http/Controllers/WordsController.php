<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WordsController extends Controller
{
    public function index()
    {
     return view('words.index');   
    }
}
