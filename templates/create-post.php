<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Music App - Create Post</title>

    <meta name="title" content="Music App">
    <meta name="author" content="Daniel Huynh and Alex Fetea">
    <meta name="description" content="Create a new post for the music app">
    <meta name="keywords" content="define keywords for search engines">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/opt/src/music-social-media/styles/styles.css">
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
    </header>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6"> 
                <h1 class="text-center mb-4">Create New Post</h1>
                <form action="?command=submit-new-post" method="post">
                    <div class="mb-3">
                        <label for="post-title" class="form-label">Post Title</label>
                        <input type="text" class="form-control" id="post-title" name="post-title" required>
                    </div>
                    <div class="mb-3">
                        <label for="post-content" class="form-label">Post Content</label>
                        <textarea class="form-control" id="post-content" name="post-content" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="song-title" class="form-label">Choose a Song</label>
                        <select class="form-control" id="song-title" name="song-title" required>
                            <option value="" disabled selected>Select a song</option>
                            <?php foreach ($songs as $song): ?>
                                <option value="<?= $song['id'] ?>"><?= $song['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>
