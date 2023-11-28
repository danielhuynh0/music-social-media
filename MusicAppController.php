<?php
// Authors: Daniel Huynh (tap7ke) and Alex Fetea (pvn5nv)
require_once('Database.php');
require_once('Config.php');



class MusicAppController
{
    private $db;

    // private $path = "/students/tap7ke/students/tap7ke/src";
    private $path = "/opt/src/music-social-media/";

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
            // Display the login form
            $this->showLogin();
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errorMsg = "";

            if (!empty($_POST["username"]) && !empty($_POST["passwd"])) {
                // Check if user exists in the database
                $res = $this->db->query("SELECT * FROM users WHERE username = $1;", $_POST["username"]);

                if (!empty($res)) {
                    // Verify password
                    if (password_verify($_POST["passwd"], $res[0]["password"])) {
                        // Set session variables and redirect
                        $_SESSION["username"] = $res[0]["username"];
                        $_SESSION["user_id"] = $res[0]["id"];
                        header("Location: ?command=home");
                        exit;
                    } else {
                        $errorMsg = "Incorrect password.";
                    }
                } else {
                    $errorMsg = "User does not exist.";
                }
            } else {
                $errorMsg = "Username and password are required.";
            }

            if ($errorMsg) {
                echo "<script>alert('" . $errorMsg . "');</script>";
                $this->showLogin();
            }
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // Display the registration form
            $this->showRegister();
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errorMsg = "";

            if (!empty($_POST["username"]) && !empty($_POST["passwd"])) {
                // Check if username already exists
                $userCheck = $this->db->query("SELECT 1 FROM users WHERE username = $1;", $_POST["username"]);

                if (empty($userCheck)) {
                    $pattern = "/^[a-zA-Z0-9]*[0-9][a-zA-Z0-9]*$/";

                    if (!preg_match($pattern, $_POST["passwd"])) {
                        $errorMsg = "Please enter a strong password (use at least one number).";
                    } else {
                        // Insert new user into database
                        $hashedPassword = password_hash($_POST["passwd"], PASSWORD_DEFAULT);
                        $createUser = $this->db->query("INSERT INTO users (username, password) VALUES ($1, $2) RETURNING id;", $_POST["username"], $hashedPassword);

                        if (isset($createUser['error'])) {
                            $errorMsg = "Error creating user account. Please contact support.";
                        } else {
                            $_SESSION["username"] = $_POST["username"];
                            $_SESSION["user_id"] = $createUser[0]["id"];
                            header("Location: ?command=home");
                            return;
                        }
                    }
                } else {
                    $errorMsg = "Username already exists.";
                }
            } else {
                $errorMsg = "Username and password are required.";
            }

            if ($errorMsg) {
                echo "<script>alert('" . $errorMsg . "');</script>";
                $this->showRegister();
            }
        }
    }





    public function run()
    {
        $post_id = null;
        $community_id = null;
        $user_id = $_SESSION["user_id"] ?? null;




        // Get the command
        $command = "login";
        if (isset($this->input["command"])) {
            $command = $this->input["command"];
        }

        if (!$user_id && $command!='register') {
            $this->login();
            return;
        }


        if (isset($this->input["postId"])) {
            $post_id = $this->input["postId"];
        }
        if (isset($this->input["community_id"])) {
            $community_id = $this->input["community_id"];
        }

        switch ($command) {
            case "login":
                $this->login();
                break;
            case "register":
                $this->register();
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
            case "community":
                $this->showCommunity();
                break;
            case "addComment":
                $this->addComment();
                break;
            case "toggleLike":
                $this->toggleLike();
                break;
            case "getPost":
                $this->getPostById($post_id);
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
            case "post":
                $this->showPost($post_id);
                break;
            case "logout":
                $this->logout();
                break;
            default:
                $this->showHome();
                break;
        }
    }

    public function showCommunity()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Extract communityId from the GET data
            $communityId = $_GET['communityId'] ?? null;

            // Validate communityId
            if (!$communityId) {
                // Handle the error - communityId is missing
                http_response_code(400); // Bad Request
                echo "Community ID is required.";
                return;
            }

            // Fetch community details
            $community = $this->getCommunityById($communityId);

            if (!$community) {
                // Handle the case where no community is found
                http_response_code(404); // Not Found
                echo "Community not found.";
                return;
            }

            // Fetch posts for the community
            $posts = $this->getPostsByCommunityId($communityId);

            // Include the template and pass the community and posts data
            include($this->path . "templates/community.php");
        }
    }

    public function getPostsByCommunityId($communityId, $username = null)
    {
        $userId = $_SESSION["user_id"] ?? null; // Assuming user ID is stored in session

        // Fetch posts
        $query = "SELECT posts.*, users.username, songs.title AS song_title, songs.album 
              FROM posts
              JOIN users ON posts.user_id = users.id
              LEFT JOIN songs ON posts.song_id = songs.id
              WHERE posts.community_id = $1"; // Filter by community ID

        $params = [$communityId]; // Initialize query parameters array with community ID

        // Add username filter if provided
        if ($username !== null) {
            $query .= " AND users.username = $2";
            $params[] = $username; // Add username to query parameters array
        }

        $query .= " ORDER BY posts.post_date DESC";

        $posts = $this->db->query($query, $params); // Pass query and parameters array

        // Fetch like count and status for each post
        foreach ($posts as &$post) {
            // Get like count
            $likeCountQuery = "SELECT COUNT(*) AS like_count FROM post_likes WHERE post_id = $1";
            $likeCountResult = $this->db->query($likeCountQuery, [$post['id']]);
            $post['like_count'] = $likeCountResult[0]['like_count'] ?? 0;

            // Check if the current user liked the post
            if ($userId !== null) {
                $userLikeQuery = "SELECT 1 FROM post_likes WHERE post_id = $1 AND user_id = $2";
                $userLikeResult = $this->db->query($userLikeQuery, [$post['id'], $userId]);
                $post['user_liked'] = !empty($userLikeResult);
            } else {
                $post['user_liked'] = false;
            }
        }
        unset($post); // Break the reference with the last element

        return $posts;
    }




    public function showCommunities()
    {
        $username = $_SESSION["username"];
        $communities = $this->getCommunities();
        include($this->path . "templates/communities.php");
    }



    public function getCommunities()
    {
        $query = "SELECT id, name, description FROM communities";
        $result = $this->db->query($query);
        if ($result === false) {
            // Handle error - e.g., log it and/or return an empty array
            return [];
        }
        return $result;
    }

    public function getCommunityById($id)
    {
        $query = "SELECT * FROM communities WHERE id = $1";
        $result = $this->db->query($query, [$id]);
        if ($result === false || count($result) == 0) {
            // Handle error or no result found
            return null;
        }
        return $result[0];
    }


    public function toggleLike()
    {
        // Check if the request is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postId = $_POST['postId'] ?? null;
            $userId = $_SESSION['user_id'] ?? null;


            if ($userId === null) {
                header('Content-Type: application/json');
                http_response_code(403); // Forbidden
                echo json_encode(['message' => 'User not logged in']);
                return;
            }

            // Check if the user already liked the post
            $likeCheckQuery = "SELECT 1 FROM post_likes WHERE post_id = $1 AND user_id = $2";
            $likeCheckResult = $this->db->query($likeCheckQuery, [$postId, $userId]);

            $userLiked = false; // Default to user has not liked

            if (!empty($likeCheckResult)) {
                // User has already liked the post, so remove the like
                $deleteLikeQuery = "DELETE FROM post_likes WHERE post_id = $1 AND user_id = $2";
                $this->db->query($deleteLikeQuery, [$postId, $userId]);
            } else {
                // User has not liked the post, so add a like
                $addLikeQuery = "INSERT INTO post_likes (post_id, user_id) VALUES ($1, $2)";
                $this->db->query($addLikeQuery, [$postId, $userId]);
                $userLiked = true;
            }

            // Get the updated like count
            $likeCountQuery = "SELECT COUNT(*) AS like_count FROM post_likes WHERE post_id = $1";
            $likeCountResult = $this->db->query($likeCountQuery, [$postId]);
            $likeCount = $likeCountResult[0]['like_count'] ?? 0;

            // Return the updated like count and like status
            header('Content-Type: application/json');
            http_response_code(200); // OK
            echo json_encode([
                'likeCount' => $likeCount,
                'userLiked' => $userLiked
            ]);
        } else {
            header('Content-Type: application/json');
            http_response_code(403); // Forbidden
            echo json_encode(['message' => 'Post requests only']);
            return;
        }
    }




    public function addComment()
    {
        // Check if the request is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Extract postId and commentText from the POST data
            $postId = $_POST['postId'] ?? null;
            $commentText = $_POST['commentText'] ?? null;
            $userId = $_SESSION['user_id'] ?? null; // Assuming user ID is stored in session

            // Validate inputs
            if (!$postId || !$commentText || !$userId) {
                // Invalid input
                http_response_code(400); // Bad Request
                echo json_encode(['message' => 'Invalid input']);
                return;
            }

            $insertQuery = "INSERT INTO comments (post_id, user_id, comment) VALUES ($1, $2, $3)";
            $result = $this->db->query($insertQuery, [$postId, $userId, $commentText]);

            // Check if the result contains an error key
            if (isset($result['error'])) {
                // Handle database error
                http_response_code(500); // Internal Server Error
                echo json_encode(['message' => 'An error occurred: ' . $result['error']]);
            } else {
                http_response_code(200); // Created
                echo json_encode(['message' => 'Comment added successfully']);
            }
        } else {
            // If not a POST request
            http_response_code(405); // Method Not Allowed
            echo json_encode(['message' => 'Method Not Allowed']);
        }
    }



    public function showPost($post_id)
    {
        $username = $_SESSION["username"];
        $post = $this->getPostById($post_id);
        include($this->path . "templates/post.php");
    }


    public function showTest()
    {

        // Set the content type to JS
        include($this->path . "templates/test.php");
    }

    public function getLikeStatus($postId, $userId)
    {
        // Query to check if the user has liked the post
        $query = "SELECT * FROM post_likes WHERE post_id = $1 AND user_id = $2";
        $result = $this->db->query($query, [$postId, $userId]);

        return !empty($result);
    }



    public function updateLikeStatus($postId, $userId, $like)
    {
        if ($like) {
            // Add a like
            $query = "INSERT INTO post_likes (post_id, user_id) VALUES ($1, $2)";
        } else {
            // Remove a like
            $query = "DELETE FROM post_likes WHERE post_id = $1 AND user_id = $2";
        }
        $this->db->query($query, [$postId, $userId]);
    }


    public function getLikeCount($postId)
    {
        // Query to count likes for the post
        $query = "SELECT COUNT(*) FROM post_likes WHERE post_id = $1";
        $result = $this->db->query($query, [$postId]);

        return $result[0]['count'] ?? 0;
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
        $communities = $this->db->query("SELECT id, name FROM communities ORDER BY name;");


        include($this->path . "templates/create-post.php");
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
            if (!isset($_POST["community_id"]) || empty($_POST["community_id"])) {
                $this->error("community_id");
                return;
            }
            // Prepare data for insertion
            $post_title = $_POST["post-title"];
            $post_content = $_POST["post-content"];
            $song_id = $_POST["song-title"];
            $community_id = $_POST["community_id"];

            // Get the user's ID from the session username

            $userResult = $this->db->query("SELECT id FROM users WHERE username = $1;", $_SESSION["username"]);
            if (isset($userResult['error'])) {
                error_log("Database error in getting user ID: " . $userResult['error']);
                $this->error("Database error: " . $userResult['error']);
                return;
            }
            $user_id = $userResult[0]["id"];

            // Insert the new post
            $insertResult = $this->db->query("INSERT INTO posts (post_title, user_id, song_id, content, community_id) VALUES ($1, $2, $3, $4, $5);", $post_title, $user_id, $song_id, $post_content, $community_id);
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
        include($this->path . "templates/error.php");
    }

    public function showLogin()
    {
        include($this->path . "templates/login.php");
    }

    public function showRegister()
    {
        include($this->path . "templates/register.php");
    }

    public function showProfile()
    {
        $posts = $this->getPosts($_SESSION["username"]);
        include($this->path . "templates/profile.php");
    }

    public function showNotifications()
    {
        include($this->path . "templates/notifications.php");
    }

    public function showSearch()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_GET['query'])) {
                if (isset($_GET['ajax'])) {
                    header('Content-Type: application/json');
                    $searchResults = $this->performSearch($_GET['query']);
                    echo json_encode($searchResults);
                    exit;
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(["error" => "Invalid request type"]);
                    exit;
                }
            } else {
                include($this->path . "templates/search.php");
                exit;
            }
        }
    }





    private function performSearch($query)
    {
        $sql = "SELECT id, title, artist, album FROM songs WHERE 
                title ILIKE $1 OR artist ILIKE $1 OR album ILIKE $1";

        $searchResults = $this->db->query($sql, ['%' . $query . '%']);

        if (isset($searchResults['error'])) {
            error_log("Database error in search: " . $searchResults['error']);
            return [];
        }
        return $searchResults;
    }


    public function showSongDetails()
    {
        include($this->path . "templates/songDetails.php");
    }

    // private function showSearchResults($results)
    // {
    //     include($this->path . "templates/search-results.php");
    // }




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


    public function getPostById($postId)
    {
        $userId = $_SESSION["user_id"] ?? null; // Assuming user ID is stored in session

        // Query to fetch a single post by post_id
        $query = "SELECT posts.*, users.username, songs.title AS song_title, songs.album 
                  FROM posts
                  JOIN users ON posts.user_id = users.id
                  LEFT JOIN songs ON posts.song_id = songs.id
                  WHERE posts.id = $1";

        // Fetch the post
        $postResult = $this->db->query($query, [$postId]);

        if (empty($postResult)) {
            return null; // No post found
        }

        $post = $postResult[0];

        // Get like count
        $likeCountQuery = "SELECT COUNT(*) AS like_count FROM post_likes WHERE post_id = $1";
        $likeCountResult = $this->db->query($likeCountQuery, [$postId]);
        $post['like_count'] = $likeCountResult[0]['like_count'] ?? 0;

        // Check if the current user liked the post
        if ($userId !== null) {
            $userLikeQuery = "SELECT 1 FROM post_likes WHERE post_id = $1 AND user_id = $2";
            $userLikeResult = $this->db->query($userLikeQuery, [$postId, $userId]);
            $post['user_liked'] = !empty($userLikeResult);
        } else {
            $post['user_liked'] = false;
        }

        // Fetch comments for the post
        $commentsQuery = "SELECT comments.*, users.username FROM comments JOIN users ON comments.user_id = users.id WHERE post_id = $1 ORDER BY comment_date DESC";
        $commentsResult = $this->db->query($commentsQuery, [$postId]);
        $post['comments'] = $commentsResult ?? [];

        return $post;
    }





    public function getPosts($username = null)
    {
        $userId = $_SESSION["user_id"] ?? null; // Assuming user ID is stored in session

        // Fetch posts
        $query = "SELECT posts.*, users.username, songs.title AS song_title, songs.album 
                  FROM posts
                  JOIN users ON posts.user_id = users.id
                  LEFT JOIN songs ON posts.song_id = songs.id";
        if ($username !== null) {
            $query .= " WHERE users.username = '$username'";
        }
        $query .= " ORDER BY posts.post_date DESC";
        $posts = $this->db->query($query);

        // Fetch like count and status for each post
        foreach ($posts as &$post) {
            // Get like count
            $likeCountQuery = "SELECT COUNT(*) AS like_count FROM post_likes WHERE post_id = $1";
            $likeCountResult = $this->db->query($likeCountQuery, [$post['id']]);
            $post['like_count'] = $likeCountResult[0]['like_count'] ?? 0;

            // Check if the current user liked the post
            if ($userId !== null) {
                $userLikeQuery = "SELECT 1 FROM post_likes WHERE post_id = $1 AND user_id = $2";
                $userLikeResult = $this->db->query($userLikeQuery, [$post['id'], $userId]);
                $post['user_liked'] = !empty($userLikeResult);
            } else {
                $post['user_liked'] = false;
            }
        }
        unset($post); // Break the reference with the last element

        return $posts;
    }



    public function showHome()
    {
        $username = $_SESSION["username"];
        $posts = $this->getPosts();
        include($this->path . "home.php");
    }

    public function logout()
    {
        session_destroy();

        session_start();
        $this->showLogin();
        return;
    }

}
?>