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
    
    <!-- Howler.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.1/howler.core.min.js"></script>

</head>

<body>
    <?php
    // echo json_encode($post);
    include('navbar.php'); ?>

    <div class="main d-flex flex-column align-items-center">
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
                    <?= htmlspecialchars($post['post_title']) ?>
                </h2>
                <h3 class="song-info">
                    <a href="?command=songDetails&songId=<?= urlencode($post['song_id']) ?>">
                        <?= htmlspecialchars($post['song_title']) ?> -
                        <?= htmlspecialchars($post['album']) ?>
                    </a>
                </h3>
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
                <div class="player-controls d-flex justify-content-center align-items-center mt-3">
                    <!-- <button class="icon-button mx-2" title="Share"><i class="material-icons">share</i></button> -->
                    <button class="icon-button mx-2" title="Play/Pause"
                        onclick="togglePlayPause('<?= htmlspecialchars($post['song_id']) ?>', '<?= htmlspecialchars($post['song_title']) ?>')">
                        <i class="material-icons"
                            id="playPauseIcon<?= htmlspecialchars($post['song_id']) ?>">play_circle_filled</i>
                    </button>
                    <div class="like-section">
                        <button class="icon-button mx-2 like-btn" data-post-id="<?= $post['id'] ?>"
                            onclick="toggleLike(<?= $post['id'] ?>)">
                            <i class="material-icons" id="likeIcon<?= $post['id'] ?>">
                                <?= $post['user_liked'] ? 'favorite' : 'favorite_border' ?>
                            </i>
                        </button>
                        <span class="like-counter" id="likeCounter<?= $post['id'] ?>">
                            <?= $post['like_count'] ?> Likes
                        </span>
                    </div>
                </div>
                <p>
                    <?= htmlspecialchars($post['content']) ?>
                </p>
            </div>

            <!-- Comments Section -->
            <div class="comments-section mt-4">
                <h3>Comments</h3>
                <?php if (empty($post['comments'])): ?>
                    <p id='no-comments'>No comments yet</p>
                <?php else: ?>
                    <?php foreach ($post['comments'] as $comment): ?>
                        <div class="comment">
                            <strong>
                                <?= htmlspecialchars($comment['username']) ?>:
                            </strong>
                            <span>
                                <?= htmlspecialchars($comment['comment']) ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Add Comment Section -->
            <div class="add-comment-section mt-3">
                <textarea id="commentText<?= $post['id'] ?>" class="form-control"
                    placeholder="Add a comment..."></textarea>
                <button class="btn btn-primary mt-2" onclick="addComment('<?= $post['id'] ?>')">Post Comment</button>
            </div>
        </div>
    </div>

    <script>
        var username = <?= json_encode($_SESSION['username'] ?? 'Unknown User') ?>;
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

        function addComment(postId) {
            var commentText = document.getElementById('commentText' + postId).value;
            var ajax = new XMLHttpRequest();
            ajax.open("POST", "?command=addComment", true); // Update with your server endpoint
            ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            ajax.responseType = "json";
            ajax.send("postId=" + postId + "&commentText=" + encodeURIComponent(commentText));

            ajax.addEventListener("load", function () {
                if (this.status == 200) {
                    var newComment = document.createElement('div');
                    newComment.className = 'comment';
                    newComment.innerHTML = '<strong>' + username + ':</strong> <span>' + commentText + '</span>';
                    document.querySelector('.comments-section').appendChild(newComment);

                    let nocomments = document.getElementById('no-comments');

                    if(nocomments){
                        nocomments.parentNode.removeChild(nocomments);
                    }

                    document.getElementById('commentText' + postId).value = '';
                } else {
                    // Handle error and display the server's response message
                    console.error("An error occurred while adding the comment:", this.response.message);
                    alert("Error: " + this.response.message); // Displaying error message using alert for simplicity
                }
            });
        }

        function toggleLike(postId) {
            var ajax = new XMLHttpRequest();
            ajax.open("POST", "?command=toggleLike", true);
            ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            ajax.responseType = "json";
            ajax.send("postId=" + postId);

            ajax.addEventListener("load", function () {
                if (this.status == 200 && this.response) {
                    var response = this.response;
                    if ('userLiked' in response && 'likeCount' in response) {
                        document.getElementById('likeIcon' + postId).innerHTML = response.userLiked ? 'favorite' : 'favorite_border';
                        document.getElementById('likeCounter' + postId).innerHTML = response.likeCount + ' Likes';
                    } else {
                        console.error("Invalid response structure:", response);
                    }
                } else {
                    console.error("An error occurred while toggling the like:", this.response ? this.response.message : "No response");
                    alert("Error: " + (this.response ? this.response.message : "Unknown error"));
                }
            });
        }

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>