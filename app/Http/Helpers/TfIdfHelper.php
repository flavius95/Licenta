<?php

namespace App\Http\Helpers;

use Symfony\Component\DomCrawler\Crawler;

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
        
        $link = $crawler->filter('a');
        dd($link);
        $nodeValues = $crawler->filter('p')->each(function (Crawler $node, $i) {
            return $node->text();
        });

        $content_separated = implode(" ", $nodeValues);
        $split_text_words = array_count_values(str_word_count($content_separated, 1));
        
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
    
    public function parseData($url)
    {
        
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
                      $line = $url;
                }else{
                      $line = $url . $item;
                }
                
                if (!in_array($line, $result)) {
                    $result[] = $line;
                }
                
            }
        }
            
        dd($result);

    }
}
