<?php

require_once __DIR__.'/../vendor/autoload.php';

class CreateShortURLController extends ShortURLController
{
    protected $request;

    public function __construct($request){
        $this->request = $request;
        $this->create();
    }

   public function create(){
       try{
        $this->urlToShortCode($this->request['long_url']);
       }catch(Exception $e){
           echo $e->getMessage();
       }
   }
}