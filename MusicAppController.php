<!-- Authors: Daniel Huynh (tap7ke) and Alex Fetea (pvn5nv) -->

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
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // GET request: Display the login HTML
            $this->showLogin();
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // POST request: Handle the login process
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
                    $pattern = "/^[a-zA-Z0-9]*[0-9][a-zA-Z0-9]*$/";
                    if(preg_match($pattern, $_POST["passwd"]) == false) {
                        $this->error("Please enter a strong password (use at least one number).");
                        return;
                    }

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
        }
    }


    public function run()
    {
        $post_id = null;
        // Get the command
        $command = "login";
        if (isset($this->input["command"])) {
            $command = $this->input["command"];
        }
        if (isset($this->input["post_id"])) {
            $post_id = $this->input["post_id"];
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
            case "songDetails":
                $this->songDetails();
                break;
            case "delete":
                $this->deletePost($post_id);
                break;
            case "logout":
                $this->logout();
            default:
                $this->showLogin();
                break;
        }
    }

    public function deletePost($post_id)
    {
        $query = "DELETE FROM posts
        WHERE id = $post_id";

        $result = $this->db->query($query);
        header("Location: ?command=home");
    }


    public function showCreatePost()
    {
        // Fetch songs from the database
        $songs = $this->db->query("SELECT id, title FROM songs ORDER BY title;");

        include("/opt/src/music-social-media/templates/create-post.php");
    }


    public function submitNewPost()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST["post-title"]) || empty($_POST["post-title"])) {
                $this->error("Post title is required.");
                return;
            }
            if (!isset($_POST["post-content"]) || empty($_POST["post-content"])) {
                $this->error("Post content is required.");
                return;
            }
            if (!isset($_POST["song-title"]) || empty($_POST["song-title"])) {
                $this->error("Song is required.");
                return;
            }
            // Prepare data for insertion
            $post_title = $_POST["post-title"];
            $post_content = $_POST["post-content"];
            $song_id = $_POST["song-title"];

            // Get the user's ID from the session username

            $userResult = $this->db->query("SELECT id FROM users WHERE username = $1;", $_SESSION["username"]);
            if (isset($userResult['error'])) {
                error_log("Database error in getting user ID: " . $userResult['error']);
                $this->error("Database error: " . $userResult['error']);
                return;
            }
            $user_id = $userResult[0]["id"];

            // Insert the new post
            $insertResult = $this->db->query("INSERT INTO posts (post_title, user_id, song_id, content) VALUES ($1, $2, $3, $4);", $post_title, $user_id, $song_id, $post_content);
            if (isset($insertResult['error'])) {
                error_log("Database error in inserting post: " . $insertResult['error']);
                $this->error("Database error: " . $insertResult['error']);
                return;
            }

            // Redirect to home after successful post creation
            header("Location: ?command=home");
            return;
        } else {
            // Handle invalid request method
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
        $posts = $this->getPosts($_SESSION["username"]);
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
    public function showSongDetails()
    {
        include("/opt/src/music-social-media/templates/songDetails.php");
    }



    public function songDetails()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['songId'])) {
            $songId = $_GET['songId'];

            // Fetch song details from the database
            $songDetails = $this->getSongDetails($songId);

            // Convert details to JSON and store in a session
            $_SESSION['songDetailsJson'] = json_encode($songDetails);

            // Redirect to the PHP file for displaying details
            $this->showSongDetails();
            exit;
        } else {
            // Handle the case where no song ID is provided or the request method is not GET
            $this->error("Error"); // Redirect to an error page or handle differently
            exit;
        }
    }

    private function getSongDetails($songId)
    {
        $sql = "SELECT title, artist, album, genre FROM songs WHERE id = $1";

        // Ensure $songId is an integer or a string, not an array
        $result = $this->db->query($sql, (string) $songId);

        if (is_array($result) && count($result) > 0) {
            return $result[0];
        } else {
            return [];
        }
    }



    public function search()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['query'])) {
            $searchQuery = $_GET['query'];

            // Perform the search operation with sanitized input
            $searchResults = $this->performSearch($searchQuery);

            // Display search results
            $this->showSearchResults($searchResults);
        } else {
            // No search query provided, show default search page or message
            echo "Please enter a search query.";
        }
    }

    private function performSearch($query)
    {

    }

    private function showSearchResults($results)
    {

    }

    public function getPosts($username = null)
    {
        $db = new Database();
        $query = "SELECT posts.*, users.username, songs.title AS song_title, songs.album 
                  FROM posts
                  JOIN users ON posts.user_id = users.id
                  LEFT JOIN songs ON posts.song_id = songs.id";

        if ($username !== null) {
            $query .= " WHERE users.username = '$username'";
        }

        $query .= " ORDER BY posts.post_date DESC";

        return $db->query($query);
    }

    public function showHome()
    {
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