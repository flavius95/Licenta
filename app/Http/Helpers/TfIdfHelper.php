<?php

namespace App\Http\Helpers;

use Symfony\Component\DomCrawler\Crawler;
use App\Stopwords;
use Skyeng\Lemmatizer;
use Skyeng\Lemma;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TfIdfHelper
 *
 * @author oem
 */
class TfIdfHelper {
    
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
        //aici pun metoda de sanitizare


        $split_text_words = array_count_values(str_word_count($content_separated, 1));
        
        $text_words = array_keys($split_text_words);  
        //eliminate all found stopwords
        $differences = array_diff($text_words, $stopwords);
        $lm_words = $this->lemmatize($differences);
        dd($lm_words);
        $totalWords = count($split_text_words);
        $tfData= array();
        
        foreach($split_text_words as $word => $frequency)
        {
            $tfData[$word] = $frequency / $totalWords;
        }
        
        return $tfData;
    }
    
    public function generateIdf()
    {
        
    }
    
    public function getSubUrlsId()
    {                   
        $UrlPagesId = App\url::find(1)->$UrlPagesId;
        foreach($UrlPagesId as $UrlPage) {              
        }
    }
    public function getLinks($url)
    {
         $html = file_get_contents($url);
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
    
    public function getPageTf($url)
    {
        try{
            $url_trimmed = htmlspecialchars($url);
            if (!preg_match("/^(https?:\/\/+[\w\-]+\.[\w\-]+)/i",$url_trimmed)) {   
                throw new Exception('Not a valid Url');
            } else {
                $html = file_get_contents($url_trimmed);
                $tf = $this->generateTf($html);
                
                return $tf;
            }
        } catch (\Exception $ex) {
            return ['error' => true, 'errorMesg' => $ex->getMessage()];
        }
    }
    
    public function getPagesTfs($pages) {
        $tfs = [];
        
        if (count($pages)) {
             foreach ($pages as $page) {
                $subpages_tf = $this->getPageTf($page);
                $tfs[] = $subpages_tf;   
            }
        }
        return $tfs;
    }
    
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
    
    
    public function calculateIdf($subpages_nr, $words) {
        $result = [];
        
        if (count($words)) {
            foreach($words as $word => $frequency) {
                $result[$word] = $subpages_nr ? log(($subpages_nr/$frequency)) : 0;
            }
        } 
        return $result;
    }
}