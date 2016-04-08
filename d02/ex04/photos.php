#!/usr/bin/php
<?php

    function getHtml($url){
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec($curl);
        curl_close($curl);
        return ($html);
    }

    function getImgs($html, $url){
        preg_match_all("/<img[^>]+src=([^\s>]+)/i", $html, $matches);
        foreach ($matches[1] as $k => $v){
            $matches[1][$k] = trim($v, "\"");
            if (!preg_match("/^http(s?):\/\//", $matches[1][$k])){
                if (preg_match("/^\//", $matches[1][$k])){
                    preg_match("/^(http(s?):\/\/)([^\/]+)/", $url, $urlMatches);
                    $matches[1][$k] = $urlMatches[1]."".$urlMatches[3]."".$matches[1][$k];
                } else {
                    $matches[1][$k] = $url."".$matches[1][$k];
                }
            }
        }
        return ($matches);
    }

    function createFolder($url){
        $url = preg_replace("/^.*?:\/\//", '', $url);
        if (file_exists($url) && is_dir($url))
            return ($url);
        mkdir($url);
        return ($url);
    }

    function getName($img){
        preg_match("/^.*?([^\/]+)$/", $img, $matches);
        if (substr($matches[1], -1) === "\"" || substr($matches[1], -1) === "'")
            return (substr($matches[1], 0, -1));
        return ($matches[1]);
    }

    function downloadImg($imgs, $folder) {
        foreach ($imgs[1] as $img) {
            $curl = curl_init($img);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_BINARYTRANSFER,1);
            $raw = curl_exec($curl);
            curl_close ($curl);
            $fp = fopen($folder."/".getName($img),'w');
            fwrite($fp, $raw);
            fclose($fp);
        }
    }

    if ($argc < 1)
        exit();

    $html = getHtml($argv[1]);
    if (!empty($html)){
        $imgs = getImgs($html, $argv[1]);
        $folder = createFolder($argv[1]);
        downloadImg($imgs, $folder);
    }