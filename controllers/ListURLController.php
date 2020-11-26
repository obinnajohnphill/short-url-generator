<?php

require_once __DIR__.'/../vendor/autoload.php';

class ListURLController extends ShortURL
{
    /**
     * Calls the getUrlFrom database method via ShortURL class extension
     *
     * @return null
     */
    public function __construct(){
        $this->listUrl();
    }

    public function listUrl(){
       return  $this->getUrlFromDB();
    }
}