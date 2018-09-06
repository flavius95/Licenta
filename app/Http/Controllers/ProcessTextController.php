<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Url as UrlModel;
use App\Pages as PagesModel;
use \App\Http\Helpers\TextProcessorHelper;

ini_set('max_execution_time', '1800');

class ProcessTextController extends Controller
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
          $helper = new TextProcessorHelper();
          $url = $request->get('page_url');
          $text_processed = $helper->getPageTf($url);

          if (!empty($text_processed['error']) && !empty($text_processed['errorMsg'])) {
              exit;
          }
          $subpages = $helper->getLinks($url);
          // dd(count($subpages));
          $subpages_tf_words = $helper->getPagesTfs($subpages);

          $collection = array_keys($text_processed);

          foreach ($subpages_tf_words as $page_words) {
              $collection += array_keys($page_words);
          }
          //iterate inside pages and words and calculate aparition into documents

          $words_appearance = [];
          foreach ($collection as $word) {
              $words_appearance[$word] = 0;
              foreach ($subpages_tf_words as $pg) {
                  if (!empty($pg[$word]) && is_numeric($pg[$word])) {
                     $words_appearance[$word] += intval($pg[$word] * count($pg));
                  }

              }
          }

          $url_model = new UrlModel([
              'url' => json_encode($url),
              'tf_words' => json_encode($text_processed),
          ]);

          $idf_words = $helper->calculateIdf(count($subpages), $words_appearance);
          dd($idf_words);

          $searched_url = $url_model::where('url', $url)->get();
          if($searched_url->isEmpty())
          {
              $url_model->save();
          } else {
              return redirect('/url/');
          }
    }
}
