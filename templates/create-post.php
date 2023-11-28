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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4">Create New Post</h1>
                <form id="submitPostForm" method="post">
                    <div class="mb-3">
                        <label for="post-title" class="form-label">Post Title</label>
                        <input type="text" class="form-control" id="post-title" name="post-title" required>
                    </div>
                    <div class="mb-3">
                        <label for="post-content" class="form-label">Post Content</label>
                        <textarea class="form-control" id="post-content" name="post-content" rows="3"
                            required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="song-title" class="form-label">Choose a Song</label>
                        <select class="form-control" id="song-title" name="song-title" required>
                            <option value="" disabled selected>Select a song</option>
                            <?php foreach ($songs as $song): ?>
                                <option value="<?= $song['id'] ?>">
                                    <?= $song['title'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="community_id" class="form-label">Choose a Community</label>
                        <select class="form-control" id="community_id" name="community_id" required>
                            <option value="" disabled selected>Select a Community</option>
                            <?php foreach ($communities as $community): ?>
                                <option value="<?= $community['id'] ?>">
                                    <?= $community['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#submitPostForm').submit(function (event) {
                event.preventDefault();

                var formData = {
                    'post-title': $('#post-title').val(),
                    'post-content': $('#post-content').val(),
                    'song-id': $('#song-title').val(),
                    'community_id': $('#community_id').val()
                };

                $.ajax({
                    type: 'POST',
                    url: '?command=submit-new-post',
                    data: formData,
                    dataType: 'json',
                    encode: true
                })
                    .done(function (data) {
                        if (data.success) {
                            window.location.href = '?command=home';
                        } else {
                            alert(data.message);
                        }
                    })
                    .fail(function (error) {
                        console.log(error.responseText)
                        alert("An error occurred: " + error.responseText);
                    });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>