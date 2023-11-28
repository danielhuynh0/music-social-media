<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Music App - Profile</title>
    <meta name="author" content="<!-- Authors: Daniel Huynh (tap7ke) and Alex Fetea (pvn5nv) -->">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/students/tap7ke/students/tap7ke/src/scripts/toggle-dark-mode.js"></script>
</head>

<body>
    <header class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a href="?command=home" class="navbar-brand">Music App</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <button id="darkModeToggle" class="btn btn-light m-3">Toggle Dark Mode</button>

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
                <h3>
                    <?php echo $_SESSION["username"]; ?>
                </h3>
                <p>Joined: January 1, 2023</p>
            </div>
        </div>

        <div class="main d-flex flex-column align-items-center">
            <h1 id="feed-heading" class="mt-4">Your Feed</h1>

            <?php foreach ($posts as $post): ?>
                <div class="feed-item card p-5 m-3 w-75">
                    <div class="feed-item-header d-flex align-items-center">
                        <img src="/images/profile.jpg" alt="profile picture" class="feed-item-profile-picture">
                        <h4 class="ml-3">@
                            <?= $post['username'] ?>
                        </h4>
                    </div>

                    <div class="feed-item-content mt-3">
                        <h2 class="post-title">
                            <?= $post['song_title'] ?> -
                            <?= $post['album'] ?>
                        </h2>

                        <!-- Clickable Song Link -->
                        <h3 class="song-info">
                            <a href="?command=songDetails&songId=<?= urlencode($post['song_id']) ?>">
                                <?= $post['song_title'] ?> -
                                <?= $post['album'] ?>
                            </a>
                        </h3>

                        <div class="img-wrapper">
                            <img src="images/album.jpg" alt="album cover" class="feed-item-post-image mb-3">
                            <input type="range" class="custom-range mt-3" title="song-scroll-bar">
                        </div>

                        <audio class="player" src="path_to_music_file.mp3" preload="auto"></audio>
                        <div class="player-controls d-flex justify-content-center align-items-center mt-3">
                        </div>
                        <p>
                            <?= $post['content'] ?>
                        </p>
                    </div>

                    <div class="feed-item-footer d-flex flex-row flex-wrap justify-content-left">
                        <button class="text-button mx-2">Comments</button>
                        <a href="?command=delete&post_id=<?= $post['id'] ?>" class="text-button mx-2 link-dark">Delete Post</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>



</body>

</html>