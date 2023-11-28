<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Music App - Search</title>
    <meta name="author" content="Daniel Huynh (tap7ke) and Alex Fetea (pvn5nv)">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="container mt-4">
        <h1 class="text-center">Search for Music</h1>
        <div class="search-bar mt-4 d-flex justify-content-center">
            <input type="text" class="form-control w-50" id="searchInput" placeholder="Enter artist, song, or album...">
            <button class="btn btn-primary ml-2" id="searchButton">Search</button>
        </div>

        <div id="searchResults" class="mt-4"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        //Event Listener
        document.getElementById('searchButton').addEventListener('click', function () {
            var query = document.getElementById('searchInput').value;

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '?command=search&query=' + encodeURIComponent(query) + '&ajax=1', true);

            xhr.onload = function () {
                try {
                    console.log(this.responseText)
                    var results = JSON.parse(this.responseText);

                    var output = '';

                    if (Array.isArray(results)) {
                        if (results.length > 0) {
                            output = '<ul class="list-group">';
                            results.forEach(function (song) {
                                output += `<li class="list-group-item">
                                          <h3 class="song-info">
                                              <a href="?command=song&songId=${encodeURIComponent(song.id)}">
                                                  ${song.title} - ${song.album}
                                              </a>
                                          </h3>
                                       </li>`;
                            });
                            output += '</ul>';
                        } else {
                            output = '<p>No results found for your search.</p>';
                        }
                    } else {
                        console.error("Non-array response received:", results);
                    }

                    document.getElementById('searchResults').innerHTML = output;
                } catch (e) {
                    console.error("Error parsing JSON: ", e);
                }
            };
            xhr.send();
        });
    </script>
</body>

</html>