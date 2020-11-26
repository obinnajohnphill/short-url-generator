<?php

require_once __DIR__.'/../vendor/autoload.php';

class DeleteShortURLController extends ShortURLController
{
    protected $request;

    public function __construct($request){
        $this->request = $request;
        $this->delete();
    }

   public function delete(){
       try{
        $this->deleteUrlShortCode($this->request);
       }catch(Exception $e){
           echo $e->getMessage();
       }
   }
}