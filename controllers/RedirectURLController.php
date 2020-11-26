<?php

require_once __DIR__.'/../vendor/autoload.php';

class RedirectURLController extends ShortURLController
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
        $this->redirect();
    }

    public function redirect(){
                try{
                    $url = $this->shortCodeToUrl($this->request);
                    // Redirect to the original URL
                    header("Location: ".$url);
                    exit;
                }catch(Exception $e){
                    // Display error
                    echo $e->getMessage();
                }
    }
}