<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Url as UrlModel;
use App\Topic as TopicModel;
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
          $searched_url = UrlModel::where('link',$url)->first();

          if (!is_null($searched_url)) {
            $data = $searched_url->toArray();

            if(is_array($data) && count($data)){
               $frontend_response =  [
                 'topics' => $data['topics'],
                 'details' => $data['details']
               ];

               return response()->json($frontend_response);
            }
          }

          $text_processed = $helper->getPageTf($url);
          $topicsData = TopicModel::all()->toArray();
          if (!empty($text_processed['error']) && !empty($text_processed['errorMsg'])) {
              exit;
          }
          $subpages = $helper->getLinks($url);
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

          $idf_words = $helper->calculateIdf(count($subpages), $words_appearance);
          $topics_grouped = TopicModel::arrangeTopics($topicsData);
          $website_words  = array_keys($idf_words);
          $results = [];
          foreach ($topics_grouped as $topic => $words) {
            $common_words = $this->checkExists($website_words, $words);
            $results[$topic] = $common_words;
          }
          $details = "Cuvintele procesate: " . implode(", ", $website_words) . "<br>";
          $selected_topics = "";
          if (count($results)) {
            foreach ($results as $topic => $words) {
              $selected_topics .= count($words) ? $topic . ', ' : '';
              $details .= count($words) ? 'Topic ' . $topic . ' has words: ' . implode(', ', $words) . '<br>' : '';
            }
          }
          $url_model = new UrlModel([
              'link' => $url,
              'topics' => $selected_topics,
              'details' => $details
          ]);

          $url_model->save();
          $front_response = ['topics' => $selected_topics, 'details' => $details];
          return response()->json($front_response);


    }

    private function checkExists($website_words, $topic_words) {
      $commonWords = array_intersect($website_words, $topic_words);
        if(!count($commonWords)) {
          $commonWords = [];
          foreach($topic_words as $word) {
            foreach($website_words as $w_piece)
            if (strpos($w_piece, $word) !== FALSE) {
              $commonWords[] = $w_piece;
            }
          }
        }

      return $commonWords;
    }
}
