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
            $helper = new TfIdfHelper();
            $url = $request->get('page_url');
            $tf = $helper->getPageTf($url);

            if (!empty($tf['error']) && !empty($tf['errorMsg'])) {
                exit;
            }
            $subpages = $helper->getLinks($url);
            $subpages_tf_words = $helper->getPagesTfs($subpages);

            $collection = collect(array_keys($tf));
            foreach ($subpages_tf_words as $page_words) {
                
                $intersection = $collection->intersect(array_keys($page_words));
                
            }

           $words_intersection = $intersection->all();

            //iterate inside pages and words and calculate aparition into documents

            $words_appearance = [];
            foreach ($words_intersection as $word) {
                $words_appearance[$word] = 0;
                foreach ($subpages_tf_words as $pg) {
                    if (!empty($pg[$word]) && is_numeric($pg[$word])) {
                        
                       $words_appearance[$word] += intval($pg[$word] * count($pg));
                    }

                } 
            }
            $idf_calculation = $helper->calculateIdf(count($subpages), $words_appearance);
            $url_model = new UrlModel([
                'url' => json_encode($url),
                'tf_words' => json_encode($tf),
            ]);
            $searched_url = $url_model::where('url', $url)->get();
            if($searched_url->isEmpty())
            {
                $url_model->save();
                  //iterate between idf data (array) and save them into db
                if (count($subpages)) {
                    $dataPages = [];
                    foreach ($subpages as $line) {
                        $subpage_tf = $helper->getPageTf($line);
                        if (!empty($subpage_tf['error']) && !empty($subpage_tf['errorMsg'])) {
                            $subpage_tf = ['error' => $subpage_tf['errorMsg']];
                        }
                        $dataPages[] = new PagesModel([
                            'url_id' => $url_model->id,
                            'sub_urls' => $line,
                            'tf_words' => json_encode($subpage_tf), 
                        ]);
                    }
                  $url_model->pages()->saveMany($dataPages);
                }
            } 
            else
            {
                return redirect('/url/create');
            }
    }
}

