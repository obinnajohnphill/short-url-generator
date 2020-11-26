<?php

require_once __DIR__.'/../vendor/autoload.php';

class ShortURL
{

    protected static $table = "short_urls";
    protected static $checkUrlExists = false;

    protected $database;
    protected $timestamp;
    protected $long_url;
    protected $short_code;
    protected $created;
    protected $hits;
    protected $id;


    /**
     *
     * Instantiates database class
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }


    public function urlExistsInDB($url){
        try {
            $conn = new Database();
            $connection = $conn->getConnection();
            $query = "SELECT short_code FROM ".self::$table."   WHERE long_url=? LIMIT 1";
            $stmt =  $connection->prepare($query);
            if(!$stmt){
                echo "Prepare statement failed: (".  $connection->errno.") ". $connection->error."<br>";
            }
            $stmt->bind_param("i", $person_id);
            $stmt->execute();
            $stmt->execute();
            $result = $stmt->get_result();
            if(isset($result) AND !empty($result)){
                while ($row = $result->fetch_assoc()) {
                    return $row["short_code"];
                }
            }else{
                return false;
            }
        }
        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }

    public function insertUrlInDB($url, $code){
        try {
            $conn = new Database();
            $connection = $conn->getConnection();

            // sanitize
            $this->long_url = htmlspecialchars($url);
            $this->short_code = htmlspecialchars($code);
            $this->created = date('Y-m-d H:i:s');

            // prepare and bind
            $stmt = $connection->prepare("INSERT INTO ".self::$table." (long_url, short_code, created) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $long_url, $short_code, $created);
            if(!$stmt){
                echo "Prepare statement failed: (".  $connection->errno.") ". $connection->error."<br>";
            }
            // set parameters and execute
            $long_url = $this->long_url;
            $short_code = $this->short_code;
            $created = $this->created;
            $stmt->execute();
            return $stmt->insert_id;
        }
        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }




    public function getUrlFromDB()
    {
        try {
            $sql = "SELECT * FROM ".self::$table." ORDER BY created ASC ";
            $conn = new Database();
            $connection = $conn->getConnection();
            $stmt = $connection->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = array("long_url" => $row['long_url'], "short_url" => $row['short_code']);
            }
            return $data;
        }
        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }


    public function getSpecificUrl($short_code)
    {
        try {
            $sql = "SELECT * FROM ".self::$table."  WHERE short_code=?";
            $conn = new Database();
            $connection = $conn->getConnection();
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s", $short_code);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
               return $row;
            }
        }
        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }


    /**
     *
     * Update the hit-counter
     *
     * @return null
     */
    public function incrementCounter($id){
            try {
                $conn = new Database();
                $connection = $conn->getConnection();

                // prepare and bind


                $stmt = $connection->prepare("UPDATE  ".self::$table." SET  hits = ? WHERE id  = ? ");
                $stmt->bind_param('ii', $id,$hits);

                // set parameters and execute
                $hits = $hits+1 ;
                $stmt->execute();
                $stmt->close();
                $connection->close();
            }
            catch(Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
        }


}