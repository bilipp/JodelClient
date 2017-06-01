<?php
/**
 * Created by PhpStorm.
 * User: bilipp
 * Date: 31.05.17
 * Time: 00:03
 */

namespace JodelWrapper;


class relatedPosts
{
    public function request($text){
        
        $text = htmlspecialchars($text);
        $text = str_replace(array("\r", "\n"), '', $text);
        preg_match_all('/#([^\s]+)/', $text, $matches);
        $hashtag = $matches[0][0];

        $json_data = '{ "stored_fields": [ "hashtag", "content" ], "query": { "dis_max": { "queries": [ { "more_like_this" : { "fields" : ["hashtag"], "like" : "'.$hashtag.'", "min_term_freq" : 1, "max_query_terms" : 12, "boost": 2 } }, { "more_like_this" : { "fields" : ["content"], "like" : "'.$text.'", "min_term_freq" : 1, "max_query_terms" : 12, "boost": 1 } } ] } } }';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://51.4.205.44:9200/jodel/_search");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$json_data);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        curl_setopt($ch, CURLOPT_USERPWD, "elastic:changeme");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("auth=PLAIN"));
        $jodel_data = curl_exec($ch);
        curl_close($this->ch);
        return $jodel_data;
    }
}