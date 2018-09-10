<?php

namespace App\Http\Helpers;

use Symfony\Component\DomCrawler\Crawler;
use App\Stopwords;
use Skyeng\Lemmatizer;
use \GuzzleHttp\Client;

/**
 * Description of TextProcessorHelper
 *
 * @author Flavius Ilina
 */
class TextProcessorHelper {
    
    /**
     * 
     * @param type $html
     * @return type
     */
    public function generateTf($html)
    {
        $crawler = new Crawler($html);
        $language = $crawler->filter('html')->attr('lang');
        //get stopwrds for languages
        $stopwords_model = new Stopwords();
        $stopwords_array= $stopwords_model::where('language', $language)->get()->toArray();
        $stopwords = ["-"];
        foreach($stopwords_array as $sword) {
            $stopwords[] = $sword['words'];
        }
        $nodeValues = $crawler->filter('p')->each(function (Crawler $node, $i) {
            return $node->text();
        });

        //transform text to lowercase
        $words_map = array_map('strtolower', $nodeValues);
        $content_separated = implode(" ", $words_map);


        $split_text_words = array_count_values(str_word_count($content_separated, 1));

        $text_words = array_keys($split_text_words);
        //eliminate all found stopwords

        $differences = array_diff($text_words, $stopwords);

        $lm_words = $this->lemmatize($differences);
        $totalWords = count($lm_words);
        $tfData= array();

        foreach($split_text_words as $word => $frequency)
        {
            $tfData[$word] = $frequency / $totalWords;
        }

        return $tfData;
    }

    /**
     * 
     * @param type $url
     * @return string
     */
    public function getLinks($url)
    {
         $client = new Client();
         $req = $client->get($url);
         $html = $req->getBody()->getContents();
         $crawler = new Crawler($html);

        $found = $crawler->filter('a')->each(function (Crawler $node, $i) {
            return $node->attr('href');
        });
        $result = [];
        foreach ($found as $item)
        {

            if (!in_array($item, array('javascript:void(0)', 'javascript:void(0);'))) {

                if(strpos($item, '//') !== false) {
                    continue;
                }else{
                      $line = $url . $item;
                }

                if(!in_array($line, $result)) {
                    $result[] = $line;
                }
            }
        }

        return $result;

    }

    /**
     * 
     * @param type $url
     * @return type
     * @throws Exception
     */
    public function getPageTf($url)
    {
        try{
            $url_trimmed = htmlspecialchars($url);
            if (!preg_match("/^(https?:\/\/+[\w\-]+\.[\w\-]+)/i",$url_trimmed)) {
                throw new Exception('Not a valid Url');
            } else {
                $client = new Client();
                $req = $client->get($url_trimmed);
                $html = $req->getBody()->getContents();
                $tf = $this->generateTf($html);

                return $tf;
            }
        } catch (\Exception $ex) {
            return ['error' => true, 'errorMesg' => $ex->getMessage()];
        }
    }
    
    /**
     * 
     * @param type $pages
     * @return type
     */
    public function getPagesTfs($pages) {
        $tfs = [];

        if (count($pages)) {
             foreach ($pages as $page) {
                $subpage_tf = $this->getPageTf($page);
                if (count($subpage_tf)) {
                    $tfs[] = $subpage_tf;
                }

            }
        }
        return $tfs;
    }
    
    /**
     * 
     * @param type $words
     * @return type
     */
    public function lemmatize($words) {
        $lm = [];
        if(count($words)) {
            $lemmatizer_model = new Lemmatizer();
            foreach ($words as $word) {
                $lemmatize = $lemmatizer_model->getOnlyLemmas($word);
                if(is_array($lemmatize)) {
                    $lm[] = $lemmatize[0];
                }

            }
        }
        return $lm;
    }

    /**
     * 
     * @param type $subpages_nr
     * @param type $words
     * @return type
     */
    public function calculateIdf($subpages_nr, $words) {
        $result = [];

        if (count($words)) {
            foreach($words as $word => $frequency) {
                $word_weight = $subpages_nr && $frequency ? log(($subpages_nr/$frequency)) : 0;
                if ($word_weight >= 0.5) {
                    $result[$word] = $subpages_nr ? log(($subpages_nr/$frequency)) : 0;
                }
            }
        }
        return $result;
    }
}
