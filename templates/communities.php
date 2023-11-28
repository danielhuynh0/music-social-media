<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Music App - Communities</title>
    <meta name="author" content="<!-- Authors: Daniel Huynh (tap7ke) and Alex Fetea (pvn5nv) -->">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="/opt/src/music-social-media/scripts/toggle-dark-mode.js"></script>
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

                <button id="darkModeToggle" class="btn btn-light m-3">Toggle Dark Mode</button>

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

    <div class="container mt-4">
        <h1 class="text-center mb-4">Communities</h1>
        
        <div class="search-bar my-4 d-flex justify-content-center">
            <input type="text" class="form-control w-50" placeholder="Search communities...">
            <button class="btn btn-primary ml-2">Search</button>
        </div>

        <div class="communities-list">
            <div class="row">
                <!-- Community A -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><a href="#" class="text-decoration-none">Community A</a></h5>
                            <p class="card-text">Short description about Community A...</p>
                            <ul class="list-unstyled">
                                <li><strong>Active Users:</strong> 1,200</li>
                                <li><strong>Total Likes:</strong> 15,000</li>
                            </ul>
                            <a href="#" class="btn btn-primary">Join</a>
                        </div>
                    </div>
                </div>

                <!-- Community B -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><a href="#" class="text-decoration-none">Community B</a></h5>
                            <p class="card-text">Short description about Community B...</p>
                            <ul class="list-unstyled">
                                <li><strong>Active Users:</strong> 980</li>
                                <li><strong>Total Likes:</strong> 10,300</li>
                            </ul>
                            <a href="#" class="btn btn-primary">Join</a>
                        </div>
                    </div>
                </div>
                <!-- More communities can be added here -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
