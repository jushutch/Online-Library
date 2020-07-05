<?php

class ISBNService
{
    public function getBookFromAPIByISBN($isbn) {
        $curl = curl_init();
        $url = 'https://www.googleapis.com/books/v1/volumes?q=isbn:'.$isbn;
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ]);
        $result = curl_exec($curl);
        if (!curl_exec($curl)) {
            die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
        }
        $result = json_decode($result);
        $result = $result->items[0]->volumeInfo;
        curl_close($curl);
        return $result;
    }

}