<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Music App - Song</title>
    <meta name="author" content="Daniel Huynh (tap7ke) and Alex Fetea (pvn5nv)">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"
        integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Song Details</h1>
            </div>
            <div class="card-body">
                <div id="title"></div>
                <div id="artist"></div>
                <div id="album"></div>
                <div id="genre"></div>
                <div id="message"></div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            var urlParams = new URLSearchParams(window.location.search);
            var songId = urlParams.get('songId');

            if (!songId) {
                $("#message").text("No song ID provided.");
                return;
            }

            var formData = {
                'songId': songId
            };

            $.ajax({
                type: 'GET',
                url: '?command=songDetails',
                data: formData,
                dataType: 'json',
                encode: true
            }).done(function (data) {
                if (data.status === "success") {
                    $("#title").text("Title: " + (data.data['title'] || 'N/A'));
                    $("#artist").text("Artist: " + (data.data.artist || 'N/A'));
                    $("#album").text("Album: " + (data.data.album || 'N/A'));
                    $("#genre").text("Genre: " + (data.data.genre || 'N/A'));
                } else {
                    $("#message").text(data.message || 'An error occurred.');
                }
            }).fail(function (error) {
                console.log(error.responseText);
                $("#message").text("An error occurred: " + error.responseText);
            });
        });
    </script>


</body>

</html>