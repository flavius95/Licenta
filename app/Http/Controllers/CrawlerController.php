<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CrawlerController extends Controller
{
        public function create()
    {
        return view('urls.createcrawler');
    }
}
