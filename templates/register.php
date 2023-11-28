<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Music App - Register</title>

    <meta name="title" content="Music App">
    <meta name="author" content="Daniel Huynh, Alex Fetea">
    <meta name="description" content="User feed for the music app">
    <meta name="keywords" content="music, app, social media, user feed">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"
        integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Register</h2>
                <form id="loginForm" action="?command=register" method="post" class="m-3">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username"
                            aria-describedby="usernameHelp" aria-label="Username" required>
                        <div id="usernameHelp" class="form-text">Your unique username for the Music App.</div>
                    </div>
                    <div class="mb-3">
                        <label for="passwd" class="form-label">Password</label>
                        <input type="password" class="form-control" id="passwd" name="passwd"
                            aria-describedby="passwdHelp" aria-label="Password" required>
                        <div id="passwdHelp" class="form-text">Enter a strong password (use at least one number)!</div>
                    </div>

                    <p id="errorMessage" class="text-danger"></p>

                    <button type="submit" class="btn btn-primary">Register</button>
                    <a href="?command=login" class="btn btn-secondary">Login</a>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

</body>

</html>
