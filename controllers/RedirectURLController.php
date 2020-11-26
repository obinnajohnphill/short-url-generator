<?php

require_once __DIR__.'/../vendor/autoload.php';

class RedirectURLController extends ShortURLController
{
    protected $request;

    /**
     * Instantiates the ShortURLController class via extension
     * Calls the redirect method
     * @return null
     */
    public function __construct($request)
    {
        $this->request = $request;
        $this->redirect();
    }

    /**
     * Redirects the short url to the original url
     *
     * @return null
     */
    public function redirect(){
                try{
                    $url = $this->shortCodeToUrl($this->request);
                    header("Location: ".$url);
                    exit;
                }catch(Exception $e){
                    echo $e->getMessage();
                }
    }
}