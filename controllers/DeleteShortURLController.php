<?php

require_once __DIR__.'/../vendor/autoload.php';

class DeleteShortURLController extends ShortURLController
{
    protected $request;

    /**
     * Instantiates the ShortURLController class via class extension
     *
     * @return null
     */
    public function __construct($request){
        $this->request = $request;
        $this->delete();
    }

    /**
     * Calls the delete url method
     *
     * @return null
     */
   public function delete(){
       try{
        $this->deleteUrlShortCode($this->request);
       }catch(Exception $e){
           echo $e->getMessage();
       }
   }
}