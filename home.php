<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Music App - User Feed</title>
    <meta name="author" content="Daniel Huynh (tap7ke) and Alex Fetea (pvn5nv)">
    <meta name="description" content="User feed for the music app">
    <meta name="keywords" content="music, social media, user feed">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"
        integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.1/howler.core.min.js"></script>
</head>

<body>
    <?php include('templates/navbar.php'); ?>

    <div class="main d-flex flex-column align-items-center">
        <!-- Create New Post Section -->
        <div class="d-flex flex-column align-items-center card p-5 w-100 mb-3">
            <h3 class="mb-5">Create New Post</h3>
            <button>
                <a href="?command=create-post" class="btn">Create Post</a>
            </button>
        </div>

        <!-- Feed Heading -->
        <h1 id="feed-heading" class="mt-3">Your Feed</h1>
        <?php foreach ($posts as $post): ?>

            <div class="feed-item card p-5 m-3 w-75">
                <!-- Post Header -->
                <div class="feed-item-header d-flex align-items-center">
                    <img src="images/profile.jpg" alt="profile picture" class="feed-item-profile-picture">
                    <h4 class="ml-3">@
                        <?= htmlspecialchars($post['username']) ?>
                    </h4>
                </div>

                <!-- Post Content -->
                <div class="feed-item-content mt-3">
                    <h2 class="post-title">
                        <a href="?command=post&postId=<?= urlencode($post['id']) ?>">
                            <?= htmlspecialchars($post['post_title']) ?>
                    </h2>

                    <!-- Song Information -->
                    <h3 class="song-info">
                        <a href="?command=song&songId=<?= urlencode($post['song_id']) ?>">
                            <?= htmlspecialchars($post['song_title']) ?> -
                            <?= htmlspecialchars($post['album']) ?>
                        </a>
                    </h3>

                    <!-- Album Image -->
                    <div class="img-wrapper">
                        <img src="images/album.jpg" alt="album cover" class="feed-item-post-image mb-3">
                    </div>

                    <input type="range" class="custom-range mt-3" id="seekBar<?= htmlspecialchars($post['id']) ?>" value="0"
                        min="0" max="100" step="1" oninput="seekAudio('<?= htmlspecialchars($post['id']) ?>', this.value)"
                        title="song-scroll-bar">
                    <script>
                        var sound<?= htmlspecialchars($post['song_id']) ?> = new Howl({
                            src: ['audio/<?= htmlspecialchars($post['song_title']) ?>.mp3']
                        });
                    </script>

                    <!-- Player Controls -->
                    <div class="player-controls d-flex justify-content-center align-items-center mt-3">
                        <button class="icon-button mx-2" title="Play/Pause"
                            onclick="togglePlayPause('<?= htmlspecialchars($post['id']) ?>', '<?= htmlspecialchars($post['song_id']) ?>', '<?= htmlspecialchars($post['song_title']) ?>')">
                            <i class="material-icons" id="playPauseIcon<?= htmlspecialchars($post['id']) ?>">
                                play_circle_filled
                            </i>
                        </button>
                    </div>

                    <p>
                        <?= htmlspecialchars($post['content']) ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        var sounds = {};
        function initAndPlaySound(post_id, song_id, song_title) {
            if (!sounds[post_id]) {
                sounds[post_id] = new Howl({
                    src: ['audio/' + song_title + '.mp3'],
                    onplay: function () {
                        document.getElementById('playPauseIcon' + post_id).innerHTML = 'pause_circle_filled';
                        requestAnimationFrame(() => updateSeekBar(post_id, song_id));
                    }
                });
            }
            sounds[post_id].play();
        }
        function togglePlayPause(post_id, song_id, song_title) {
            var sound = sounds[post_id];
            var playPauseIcon = document.getElementById('playPauseIcon' + post_id);
            if (sound && sound.playing()) {
                sound.pause();
                playPauseIcon.innerHTML = 'play_circle_filled';
            } else {
                initAndPlaySound(post_id, song_id, song_title);
            }
        }
        function updateSeekBar(post_id, song_id) {
            var sound = sounds[post_id];
            if (sound && sound.playing()) {
                var seekBar = document.getElementById('seekBar' + post_id);
                seekBar.max = sound.duration();
                seekBar.value = sound.seek();
                requestAnimationFrame(() => updateSeekBar(post_id, song_id));
            }
        }
        function seekAudio(post_id, value) {
            var sound = sounds[post_id];
            if (sound) {
                sound.seek(value);
            }
        }
    </script>]
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>