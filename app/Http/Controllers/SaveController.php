<?php

namespace App\Http\Controllers;

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
        $url = new UrlModel([
            'url' => $request->get('page_url'),
        ]);
        $url->save();
        return redirect('/url/create');
        }
    }
    

/**
 * Display the specified resource.
 * 
 * @param int $id
 * @return \Illuminate\Http\Response
 */
    public function show($id)
    {
        //
    }
}

