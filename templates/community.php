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


    <!-- Howler.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.1/howler.core.min.js"></script>
</head>


<body>
    <?php include('navbar.php'); ?>

    <div class="main d-flex flex-column align-items-center">

    <div class="feed-item p-5 m-3 w-75">
        <div class="card h-100 shadow-sm"> <!-- Single card with shadow and height adjustment -->
            <div class="card-header bg-primary text-white"> <!-- Card header with background -->
                <h5 class="card-title mb-0"> <!-- Adjusted margins -->
                    <a href="?command=community&id=<?= htmlspecialchars($community['id']) ?>" class="text-white text-decoration-none">
                        <?= htmlspecialchars($community['name']) ?>
                    </a>
                </h5>
            </div>
            <div class="card-body">
                <p class="card-text">
                    <?= htmlspecialchars($community['description']) ?>
                </p>
            </div>
        </div>
    </div>


        <!-- Posts Loop -->
        <h2>Posts in this Community</h2>
        <!-- Posts Loop -->
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
                        <a href="?command=songDetails&songId=<?= urlencode($post['song_id']) ?>">
                            <?= htmlspecialchars($post['song_title']) ?> -
                            <?= htmlspecialchars($post['album']) ?>
                        </a>
                    </h3>

                    <!-- Album Image -->
                    <div class="img-wrapper">
                        <img src="images/album.jpg" alt="album cover" class="feed-item-post-image mb-3">
                    </div>

                    <input type="range" class="custom-range mt-3" id="seekBar<?= htmlspecialchars($post['song_id']) ?>"
                        value="0" min="0" max="100" step="1"
                        oninput="seekAudio('<?= htmlspecialchars($post['song_id']) ?>', this.value)"
                        title="song-scroll-bar">
                    <script>
                        var sound<?= htmlspecialchars($post['song_id']) ?> = new Howl({
                            src: ['/music-social-media/audio/<?= htmlspecialchars($post['song_title']) ?>.mp3']
                        });
                    </script>

                    <!-- Player Controls -->
                    <div class="player-controls d-flex justify-content-center align-items-center mt-3">
                        <button class="icon-button mx-2" title="Play/Pause"
                            onclick="togglePlayPause('<?= htmlspecialchars($post['song_id']) ?>', '<?= htmlspecialchars($post['song_title']) ?>')">
                            <i class="material-icons"
                                id="playPauseIcon<?= htmlspecialchars($post['song_id']) ?>">play_circle_filled</i>
                        </button>
                    </div>

                    <p>
                        <?= htmlspecialchars($post['content']) ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>


        <!-- JavaScript for Play/Pause Functionality -->
        <script>
            // Object to store Howler sound instances
            var sounds = {};
            function initAndPlaySound(songId, songTitle) {
                if (!sounds[songId]) {
                    sounds[songId] = new Howl({
                        src: ['/music-social-media/audio/' + songTitle + '.mp3'],
                        onplay: function () {
                            document.getElementById('playPauseIcon' + songId).innerHTML = 'pause_circle_filled';
                            requestAnimationFrame(() => updateSeekBar(songId));
                        }
                    });
                }
                sounds[songId].play();
            }
            function togglePlayPause(songId, songTitle) {
                var sound = sounds[songId];
                var playPauseIcon = document.getElementById('playPauseIcon' + songId);
                if (sound && sound.playing()) {
                    sound.pause();
                    playPauseIcon.innerHTML = 'play_circle_filled';
                } else {
                    initAndPlaySound(songId, songTitle);
                }
            }
            function updateSeekBar(songId) {
                var sound = sounds[songId];
                if (sound && sound.playing()) {
                    var seekBar = document.getElementById('seekBar' + songId);
                    seekBar.max = sound.duration();
                    seekBar.value = sound.seek();
                    requestAnimationFrame(() => updateSeekBar(songId));
                }
            }
            function seekAudio(songId, value) {
                var sound = sounds[songId];
                if (sound) {
                    sound.seek(value);
                }
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>