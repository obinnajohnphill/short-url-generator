<?php

require_once __DIR__.'/../vendor/autoload.php';

class ListURLController extends ShortURL
{
    public function __construct(){
        $this->listUrl();
    }

    public function listUrl(){
       return  $this->getUrlFromDB();
    }
}