<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Music App - User Feed</title>

    <meta name="author" content="Daniel Huynh and Alex Fetea">
    <meta name="description" content="User feed for the music app">
    <meta name="keywords" content="define keywords for search engines">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a href="?command=home" class="navbar-brand">Music App</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                        <a class="nav-link dropdown-toggle active" href="profile.html" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Profile</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="profile.html">My profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="/notifications.html">Notifications</a></li>
                            <li><a class="dropdown-item" href="#">Friends</a></li>
                            <li><a class="dropdown-item" href="#">Playlists</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="main d-flex flex-column align-items-center">
        <h1 id="feed-heading" class="mt-4">Your Feed</h1>
        <div class="feed-item card p-5 m-3 w-75">
            <div class="feed-item-header d-flex align-items-center">
                <img src="images/profile.jpg" alt="profile picture" class="feed-item-profile-picture">
                <h4 class="ml-3">@username</h4>
            </div>

            <div class="feed-item-content mt-3">
                <h2 class="post-title">My Sample Post Title - My Favorite Album</h2>
                <div class="img-wrapper">
                    <img src="images/album.jpg" alt="album cover" class="feed-item-post-image mb-3">
                
                    <input type="range" class="custom-range mt-3" title="song-scroll-bar">
                </div>
                
                <audio class="player" src="path_to_your_music_file.mp3" preload="auto"></audio>
                <div class="player-controls d-flex justify-content-center align-items-center mt-3">
                    <button class="icon-button mx-2" title="Share"><i class="material-icons">share</i></button>
                    <button class="icon-button mx-2" title="Previous"><i class="material-icons">skip_previous</i></button>
                    <button class="icon-button mx-2" title="Play"><i class="material-icons">play_circle_filled</i></button>
                    <button class="icon-button mx-2" title="Next"><i class="material-icons">skip_next</i></button>
                    <button class="icon-button mx-2" title="Like"><i class="material-icons">favorite</i></button>
                </div>
                <p>Sample post content! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
            <div class="feed-item-footer d-flex flex-row flex-wrap justify-content-left">
                <button class="text-button mx-2">Comments</button>
            </div>
        </div>

        <div class="feed-item card p-5 m-3 w-75">
            <div class="feed-item-header d-flex align-items-center">
                <img src="images/profile.jpg" alt="profile picture" class="feed-item-profile-picture">
                <h4 class="ml-3">@username</h4>
            </div>

            <div class="feed-item-content mt-3">
                <h2 class="post-title">My Sample Post Title 2 - My Favorite Album</h2>
                <div class="img-wrapper">
                    <img src="images/album.jpg" alt="album cover" class="feed-item-post-image mb-3">
                
                    <input type="range" class="custom-range mt-3" title="song-scroll-bar">
                </div>
                
                <audio class="player" src="path_to_your_music_file.mp3" preload="auto"></audio>
                <div class="player-controls d-flex justify-content-center align-items-center mt-3">
                    <button class="icon-button mx-2" title="Share"><i class="material-icons">share</i></button>
                    <button class="icon-button mx-2" title="Previous"><i class="material-icons">skip_previous</i></button>
                    <button class="icon-button mx-2" title="Play"><i class="material-icons">play_circle_filled</i></button>
                    <button class="icon-button mx-2" title="Next"><i class="material-icons">skip_next</i></button>
                    <button class="icon-button mx-2" title="Like"><i class="material-icons">favorite</i></button>
                </div>
                <p>Sample post content! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
            <div class="feed-item-footer d-flex flex-row flex-wrap justify-content-left">
                <button class="text-button mx-2">Comments</button>
            </div>
        </div>

        <div class="feed-item card p-5 m-3 w-75">
            <div class="feed-item-header d-flex align-items-center">
                <img src="images/profile.jpg" alt="profile picture" class="feed-item-profile-picture">
                <h4 class="ml-3">@username</h4>
            </div>

            <div class="feed-item-content mt-3">
                <h2 class="post-title">My Sample Post Title 3- My Favorite Album</h2>
                <div class="img-wrapper">
                    <img src="images/album.jpg" alt="album cover" class="feed-item-post-image mb-3">
                
                    <input type="range" class="custom-range mt-3" title="song-scroll-bar">
                </div>
                
                <audio class="player" src="path_to_your_music_file.mp3" preload="auto"></audio>
                <div class="player-controls d-flex justify-content-center align-items-center mt-3">
                    <button class="icon-button mx-2" title="Share"><i class="material-icons">share</i></button>
                    <button class="icon-button mx-2" title="Previous"><i class="material-icons">skip_previous</i></button>
                    <button class="icon-button mx-2" title="Play"><i class="material-icons">play_circle_filled</i></button>
                    <button class="icon-button mx-2" title="Next"><i class="material-icons">skip_next</i></button>
                    <button class="icon-button mx-2" title="Like"><i class="material-icons">favorite</i></button>
                </div>
                <p>Sample post content! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
            <div class="feed-item-footer d-flex flex-row flex-wrap justify-content-left">
                <button class="text-button mx-2">Comments</button>
            </div>
        </div>
    </div>
</body>

</html>
