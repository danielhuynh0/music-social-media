<!-- <script src="/students/tap7ke/students/tap7ke/src/scripts/toggle-dark-mode.js"></script> -->
<script src="scripts/toggle-dark-mode.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


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
</header>