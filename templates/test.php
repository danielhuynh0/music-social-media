<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Display</title>
</head>
<body>
    <h1>Data Display</h1>
    <div id="data-container">
        <!-- Data will be displayed here -->
    </div>

    <script>
        var post;
        function getPostIdFromUrl() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('postId');
        }

        // Function to fetch and display data based on postid using AJAX
        var ajax = new XMLHttpRequest();
        ajax.open("GET", `?command=getPost&postId=${getPostIdFromUrl()}`, true);
        ajax.responseType = "json";
        
        ajax.onreadystatechange = function () {
            if (ajax.readyState === 4) {
                if (ajax.status === 200) {
                    post = ajax.response;
                } else {
                    console.error('Error fetching data:', ajax.statusText);
                }
            }
        };
        // Send the request
        ajax.send();


        
    </script>
</body>
</html>
