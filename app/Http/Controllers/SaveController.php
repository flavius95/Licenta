<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Url as UrlModel;
use App\Pages as PagesModel;
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
            $searched_url = $url::where('id', 1)->get();
            if(empty($searched_url))
            {
                $url->save();
            }
            else
            {
                echo('Continue');
            }

    //iterate between idf data (array) and save them into db
            if (count($idf)) {
                $dataPages = [];
                foreach ($idf as $line) {
                    $dataPages[] = new PagesModel([
                        'url_id' => $url->id,
                        'sub_urls' => $line,
                        'tf_words' => json_encode($tf), 
                    ]);
                }
             

              $url->pages()->saveMany($dataPages);
            } 
            dd($searched_url);
        return redirect('/url/create');
        }
    }

}

