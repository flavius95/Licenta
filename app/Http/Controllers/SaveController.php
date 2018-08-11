<?php

namespace App\Http\Controllers;

use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Http\Request;
use App\url as UrlModel;

class SaveController extends Controller
{
 /**
  * Display a listing of the resource.
  * @return \Illuminate\Http\Response
  */
   public function index()
   {
       $urls = UrlModel::all()->toArray();
       
       return view('urls.index', compact('urls'));
   }
 /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('urls.create');
    }
    
    /**
     * Store a newly created resource in storage.
     * Validation for url field.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $url = htmlspecialchars($_POST['page_url']);
        if (!preg_match("/^(https?:\/\/+[\w\-]+\.[\w\-]+)/i",$url))
        {   
            echo('Not a valid Url');
        }
        else
        {
            $html = file_get_contents($url);

            $crawler = new Crawler($html);;
            $nodeValues = $crawler->filter('p')->each(function (Crawler $node, $i) {
                return $node->text();
            });
            $content_separated = implode(" ", $nodeValues);
            $content_print = substr($content_separated, 0, 200) . '...'; 
            $url = new UrlModel([
            'url' => $request->get('page_url'),
            'data' => $content_print,
        ]);
            $url->save();
        return redirect('/url/create');
        }
    }
}

