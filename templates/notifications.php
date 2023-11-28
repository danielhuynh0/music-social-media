<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Music App - Notifications</title>
    <meta name="author" content="<!-- Authors: Daniel Huynh (tap7ke) and Alex Fetea (pvn5nv) -->">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/students/tap7ke/students/tap7ke/src/scripts/toggle-dark-mode.js"></script>
</head>

<body>
<?php include('navbar.php');?>

    <div class="container mt-4">
        <h1 class="text-center">Notifications</h1>

        <div class="notifications-list mt-4">
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Username1</strong> liked your post: <a href="#">Post Title 1</a>
                    <span class="float-right">2 hours ago</span>
                </li>
                <li class="list-group-item">
                    <strong>Username2</strong> commented: "Great post!" on <a href="#">Post Title 2</a>
                    <span class="float-right">5 hours ago</span>
                </li>
                <li class="list-group-item">
                    <strong>Username3</strong> started following you.
                    <span class="float-right">1 day ago</span>
                </li>
            </ul>
        </div>

        <div class="mt-3">
            <button class="btn btn-primary">Mark All as Read</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>