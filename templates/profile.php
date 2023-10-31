<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Music App - Profile</title>
    <meta name="author" content="Daniel Huynh and Alex Fetea">
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<header class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a href="?command=home" class="navbar-brand">Music App</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a href="?command=search" class="nav-link">Search</a>
                    </li>
                    <li class="nav-item">
                        <a href="?command=communities" class="nav-link">Communities</a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown hover-dropdown">
                        <a class="nav-link dropdown-toggle active" href="javascript:void(0);" id="profileDropdown" 
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">Profile</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="?command=profile">My profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="?command=notifications">Notifications</a></li>
                            <li><a class="dropdown-item" href="#">Friends</a></li>
                            <li><a class="dropdown-item" href="#">Playlists</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
            <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </header>

    <div class="container mt-4">
        <h1 class="text-center">Profile</h1>
        
        <div class="profile-info mt-4 d-flex">
            <img src="images/profile.jpg" alt="User Profile Picture" class="rounded-circle" width="100">
            <div class="ml-3">
                <h3><?php 
                echo $_SESSION["username"]?></h3>
                <p>Email: user@example.com</p>
                <p>Joined: January 1, 2023</p>
            </div>
        </div>
        
        <div class="user-posts mt-4">
            <h3>My Posts</h3>
            <ul class="list-group">
                <?php
                require_once('../Database.php');
                require_once('../Config.php');
                $db = new Database();

                $query = "SELECT posts.*, songs.title AS song_title, songs.album AS song_album
                FROM posts
                JOIN users ON posts.user_id = users.id
                LEFT JOIN songs ON posts.song_id = songs.id
                WHERE users.username = " . $_SESSION["username"] . 
                " ORDER BY posts.post_date DESC;";
                $res = $db->query($query);

                foreach ($res as $post) {
                    
                    echo '
                        <div class="feed-item card p-5 m-3 w-75">
                            <div class="feed-item-header d-flex align-items-center">
                                <img src="/images/profile.jpg" alt="profile picture" class="feed-item-profile-picture">
                                <h4 class="ml-3">@<?= ' . $post['username'] . ' ?></h4>
                            </div>

                            <div class="feed-item-content mt-3">
                                <h2 class="post-title"><?= '.$post['post_title'].' ?></h2>
                                <h3 class="song-info"><?= '.$post['song_title'].' ?> - <?= '.$post['album'].' ?></h3>
                                <div class="img-wrapper">
                                    <img src="../images/album.jpg" alt="album cover" class="feed-item-post-image mb-3">
                                    <input type="range" class="custom-range mt-3" title="song-scroll-bar">
                                </div>
                                <audio class="player" src="path_to_music_file.mp3" preload="auto"></audio>
                                <div class="player-controls d-flex justify-content-center align-items-center mt-3">
                                    <button class="icon-button mx-2" title="Share"><i class="material-icons">share</i></button>
                                    <button class="icon-button mx-2" title="Previous"><i class="material-icons">skip_previous</i></button>
                                    <button class="icon-button mx-2" title="Play"><i class="material-icons">play_circle_filled</i></button>
                                    <button class="icon-button mx-2" title="Next"><i class="material-icons">skip_next</i></button>
                                    <button class="icon-button mx-2" title="Like"><i class="material-icons">favorite</i></button>
                                </div>
                                <p><?= ' . $post['content'] . ' ?></p>
                            </div>

                            <div class="feed-item-footer d-flex flex-row flex-wrap justify-content-left">
                                <button class="text-button mx-2">Comments</button>
                            </div>
                        </div>
                    ';
                }
                 ?>
                <li class="list-group-item">Post Title 1</li>
                <li class="list-group-item">Post Title 2</li>

            </ul>
        </div>
    </div>
    
    
</body>

</html>
