<?php
require_once('Database.php');
require_once('Config.php');

class MusicAppController {
    private $db;

    public function __construct() {
        $this->db = new Database();
        session_start();
    }

    public function loginUser($email, $password) {
        $res = $this->db->query("SELECT * FROM users WHERE email = $1;", $email);
        if (!empty($res) && password_verify($password, $res[0]["password"])) {
            $_SESSION["user_id"] = $res[0]["id"];
            $_SESSION["username"] = $res[0]["username"];
            header("Location: /home.php");
        } else {
            echo "Invalid email or password.";
        }
    }

}
?>

