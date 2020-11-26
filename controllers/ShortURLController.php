<?php

require_once __DIR__.'/../vendor/autoload.php';

class ShortURLController extends ShortURL
{

    protected static $chars = "abcdfghjkmnpqrstvwxyz|ABCDFGHJKLMNPQRSTVWXYZ|0123456789";
    protected $timestamp;
    protected static $checkUrlExists = false;
    protected static $codeLength = 7;


    public function __construct(){
        $this->timestamp = date("Y-m-d H:i:s");
    }

    /**
     * Call the validation methods and the create url short-code method
     *
     * @return null
     */
    public function urlToShortCode($url){
        if(empty($url)){
            throw new Exception("No URL was supplied.");
        }
        if($this->validateUrlFormat($url) == false){
            throw new Exception("URL does not have a valid format.");
        }

        $this->createShortCode($url);

        exit(header("Location: /"));
    }

    /**
     * Validates the url format
     *
     * @param $url
     * @return string of url
     */
    protected function validateUrlFormat($url){
        return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED);
    }

    /**
     * Creates short-code and calls the insert url methos
     *
     * @param $url
     * @return string of short code
     */
    protected function createShortCode($url){
        $shortCode = $this->generateRandomString(self::$codeLength);
        $this->insertUrlInDB($url, $shortCode);
        return $shortCode;
    }

    /**
     * Generates the short url as random string
     *
     * @param int $length
     * @return string or random type
     */
    protected function generateRandomString($length = 6){
        $sets = explode('|', self::$chars);
        $all = '';
        $randString = '';
        foreach($sets as $set){
            $randString .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++){
            $randString .= $all[array_rand($all)];
        }
        $randString = str_shuffle($randString);
        return $randString;
    }


    /**
     * Calls the validates short url method and calls the increment hits method
     *
     * @return null
     * @throws Exception
     */
    public function shortCodeToUrl($code, $increment = true){
        if(empty($code)) {
            throw new Exception("No short code was supplied.");
        }

        if($this->validateShortCode($code) == false){
            throw new Exception("Short code does not have a valid format.");
        }

        $urlRow = $this->getSpecificUrl($code);
        if(empty($urlRow)){
            throw new Exception("Short code does not appear to exist.");
        }

        if($increment == true){
            $this->incrementCounter($urlRow["id"]);
        }

        return $urlRow["long_url"];
    }

    /**
     * Validate short url
     *
     * @return boolean true or false
     */
    protected function validateShortCode($code){
        $rawChars = str_replace('|', '', self::$chars);
        return preg_match("|[".$rawChars."]+|", $code);
    }

    /**
     * Calls the delete url method
     *
     * @return null
     */
    public function deleteUrlShortCode($short_code){
        $this->deleteUrl($short_code);
    }
}