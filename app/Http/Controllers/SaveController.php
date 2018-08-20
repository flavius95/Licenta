<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\url as UrlModel;
use App\UrlPages as UrlPagesModel;
use \App\Http\Helpers\TfIdfHelper;

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
            
            $helper = new TfIdfHelper();
            $tf = $helper->generateTf($html);
            $idf = $helper->getLinks($url);

            $url = new UrlModel([
            'url' => $request->get('page_url'),
        ]);
//iterate between idf data (array) and save them into db
            if (count($idf)) {
                $dataPages = [];
                foreach ($idf as $line) {
                    $dataPages[] = [
                        'searched_url' => rand(1,9999999),
                        'sub_urls' => $line,
                        'data' => json_encode($tf), 
                        'createdAt' => time(),
                        'updatedAt' => time(),
                    ];
                }
//                dd($dataPages);
                UrlPagesModel::create($dataPages);
                $url_pages = new UrlPagesModel($dataPages);
                $url_pages->save();
            }     
            $url->save();
        return redirect('/url/create');
        }
    }

}

