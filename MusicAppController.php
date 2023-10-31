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
        $this->errorMessage = "";
        $this->db = new Database();

    }

    public function login()
    {
        // Check if the request is a POST request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (
                isset($_POST["username"]) && !empty($_POST["username"]) &&
                isset($_POST["passwd"]) && !empty($_POST["passwd"])
            ) {
                // Check if user is in database
                $res = $this->db->query("SELECT * FROM users WHERE username = $1;", $_POST["username"]);
                if (!empty($res)) {
                    // User exists, verify password
                    if (password_verify($_POST["passwd"], $res[0]["password"])) {
                        // Password is correct
                        $_SESSION["username"] = $res[0]["username"];
                        header("Location: ?command=home");
                        exit;
                    } else {
                        // Incorrect password
                        $this->error("Incorrect password.");
                        return;
                    }
                } else {
                    // User does not exist, create a new user
                    $hashedPassword = password_hash($_POST["passwd"], PASSWORD_DEFAULT);
                    $createUser = $this->db->query("INSERT INTO users (username, password) VALUES ($1, $2);", $_POST["username"], $hashedPassword);
                    
                    if (isset($createUser['error'])) {
                        // If there's an error, display it
                        $this->error("Error creating user account. Please contact support.");
                        return;
                    } else {
                        // User successfully created, set session and redirect to home
                        $_SESSION["username"] = $_POST["username"];
                        header("Location: ?command=home");
                        return; // Prevent further code execution
                    }
                }
            } else {
                // Username and password are required
                $this->error("Username and password are required.");
                return;
            }
        } else {
            // Not a POST request, show the login page
            $this->showLogin();
        }
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
            case "home":
                $this->showHome();
                break;
            case "search":
                $this->showSearch();
                break;
            case "communities":
                $this->showCommunities();
                break;
            case "test":
                $this->showTest();
                break;
            case "profile":
                $this->showProfile();
                break;
            case "notifications":
                $this->showNotifications();
                break;
            case "create-post":
                $this->showCreatePost();
                break;
            case "submit-new-post":
                $this->submitNewPost();
                break;

            case "logout":
                $this->logout();
            default:
                $this->showLogin();
                break;
        }
    }

    public function showCreatePost()
    {
        include("/opt/src/music-social-media/templates/create-post.php");
    }

    public function submitNewPost()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(!isset($_POST["post-title"]) || empty($_POST["post-title"])) {
                $this->error("Post title is required.");
                return;
            }
            if(!isset($_POST["post-content"]) || empty($_POST["post-content"])) {
                $this->error("Post content is required.");
                return;
            }
            if(!isset($_POST["song-title"]) || empty($_POST["song-title"])) {
                $this->error("Song title is required.");
                return;
            }
            $post_title = $_POST["post-title"];
            $post_content = $_POST["post-content"];
            $song_title = $_POST["song-title"];

            $song_id = $this->db->query("SELECT id FROM songs WHERE title = $1;", $song_title)[0]["id"];

            $user_id = $this->db->query("SELECT id FROM users WHERE username = $1;", $_SESSION["username"])[0]["id"];

            $this->db->query("INSERT INTO posts (post_title, user_id, song_id, content) VALUES ($1, $2, $3, $4);", $post_title, $user_id, $song_id, $post_content);

            header("Location: ?command=home");
            return;
        } else {
            $this->error("Invalid request.");
        }
    }

    public function error($errorMessage = '')
    {
        include("/opt/src/music-social-media/templates/error.php");
    }

    public function showTest()
    {
        $res = $this->db->query("select * from users;");
        $_SESSION["res"] = $res;
        include("/opt/src/music-social-media/templates/test.php");
    }

    public function showLogin()
    {
        include("/opt/src/music-social-media/templates/login.php");
    }

    public function showProfile()
    {
        include("/opt/src/music-social-media/templates/profile.php");
    }

    public function showNotifications()
    {
        include("/opt/src/music-social-media/templates/notifications.php");
    }

    public function showSearch()
    {
        include("/opt/src/music-social-media/templates/search.php");
    }

    public function showCommunities()
    {
        include("/opt/src/music-social-media/templates/communities.php");
    }



    public function getPosts() {
        // SQL query to fetch posts, joined with users and songs
        $query = "SELECT posts.*, users.username, songs.title AS song_title, songs.album 
                  FROM posts
                  JOIN users ON posts.user_id = users.id
                  JOIN songs ON posts.song_id = songs.id
                  ORDER BY posts.post_date DESC";
        return $this->db->query($query);
    }

    public function showHome() {
        $username = $_SESSION["username"];
        $posts = $this->getPosts();
        include("/opt/src/music-social-media/home.php");
    }

    public function logout()
    {
        session_destroy();

        session_start();
    }

}
?>