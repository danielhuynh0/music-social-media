<?php
require_once('Database.php');
require_once('Config.php');


class MusicAppController
{
    private $db;

    public function __construct($input)
    {
        session_start();

        $this->input = $input;
        $this->db = new Database();

    }

    public function login() {
        // need a name, email, and password
        if(isset($_POST["email"]) && !empty($_POST["email"]) &&
            isset($_POST["passwd"]) && !empty($_POST["passwd"])) {

                // Check if user is in database
                $res = $this->db->query("select * from users where email = $1;", $_POST["email"]);
                if (empty($res)) {
                    // User was not there, so insert them
                    $this->db->query("insert into users (email, password) values ($1, $2);",
                        $_POST["email"], password_hash($_POST["passwd"], PASSWORD_DEFAULT));
                    $_SESSION["email"] = $_POST["email"];
                    // Send user to the appropriate page (question)
                    header("Location: ?command=home");
                    return;
                } else {
                    // User was in the database, verify password
                    if (password_verify($_POST["passwd"], $res[0]["password"])) {
                        // Password was correct
                        $_SESSION["email"] = $res[0]["email"];
                        header("Location: ?command=home");
                        return;
                    } else {
                        $this->errorMessage = "Incorrect password.";
                    }
                }
        } else {
            $this->errorMessage = "Email and password are required.";
        }
        // If something went wrong, show the welcome page again
        $this->showLogin();
    }

    public function run()
    {
        // Get the command
        $command = "login";
        if (isset($this->input["command"])) {
            $command = $this->input["command"];
        }

        switch ($command) {
            case "login":
                $this->login();
                break;
            case "search":
                $this->showSearch();
                break;
            case "communities":
                $this->showCommunities();
                break;

            case "logout":
                $this->logout();
            default:
                $this->showLogin();
                break;
        }
    }

    public function showLogin() {
        include("/opt/src/music-social-media/templates/login.php");
    }

    public function showSearch() {
        include("/opt/src/music-social-media/templates/search.php");
    }

    public function showCommunities() {
        include("/opt/src/music-social-media/templates/communities.php");
    }



    public function showHome() {
        include("/opt/src/music-social-media/home.php");
    }

    public function logout() {
        session_destroy();

        session_start();
    }

}
?>