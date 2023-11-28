
<?php
// Authors: Daniel Huynh (tap7ke) and Alex Fetea (pvn5nv)
class Database {
    private $dbConnector;

    public function __construct() {
        $host = Config::$db["host"];
        $user = Config::$db["user"];
        $database = Config::$db["database"];
        $password = Config::$db["pass"];
        $port = Config::$db["port"];

        $this->dbConnector = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");
        if ($this->dbConnector === false) {
            error_log('Database connection error: ' . pg_last_error());
            throw new Exception("Unable to connect to the database.");
        }
    }

    public function query($query, ...$params) {
        if (count($params) == 1 && is_array($params[0])) {
            $params = $params[0];
        }
    
        $res = pg_query_params($this->dbConnector, $query, $params);
        if ($res === false) {
            // Log the error for debugging
            error_log('Database query error: ' . pg_last_error($this->dbConnector));
            return ['error' => pg_last_error($this->dbConnector)];
        }
        return pg_fetch_all($res);
    }
    
}

?>

