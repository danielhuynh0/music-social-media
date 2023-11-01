<!-- Authors: Daniel Huynh (tap7ke) and Alex Fetea (pvn5nv) -->

<?php

$host = "db";
$port = "5432";
$database = "example";
$user = "localuser";
$password = "cs4640LocalUser!"; 

$dbHandle = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");

if ($dbHandle) {
    echo "Success connecting to database<br>";
} else {
    echo "An error occurred connecting to the database<br>";
}

// Drop Existing Tables
$dropTables = [
    "DROP TABLE IF EXISTS post_shares CASCADE;",
    "DROP TABLE IF EXISTS post_likes CASCADE;",
    "DROP TABLE IF EXISTS comments CASCADE;",
    "DROP TABLE IF EXISTS posts CASCADE;",
    "DROP TABLE IF EXISTS songs CASCADE;",
    "DROP TABLE IF EXISTS users CASCADE;"
];

foreach ($dropTables as $query) {
    pg_query($dbHandle, $query);
}

// Create Users Table
$res = pg_query($dbHandle, "CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password TEXT NOT NULL
);");

if (!$res) {
    echo "An error occurred.\n";
    echo pg_last_error($dbHandle);
}

// Create Songs Table
$res = pg_query($dbHandle, "CREATE TABLE IF NOT EXISTS songs (
    id SERIAL PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    artist VARCHAR(100) NOT NULL,
    album VARCHAR(100),
    release_date DATE,
    genre VARCHAR(50)
);");

if (!$res) {
    echo "An error occurred.\n";
    echo pg_last_error($dbHandle);
}

// Create Posts Table
$res = pg_query($dbHandle, "CREATE TABLE IF NOT EXISTS posts (
    id SERIAL PRIMARY KEY,
    post_title VARCHAR(100),
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    song_id INT REFERENCES songs(id) ON DELETE SET NULL,
    content TEXT,
    post_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    likes INT DEFAULT 0
);");

if (!$res) {
    echo "An error occurred.\n";
    echo pg_last_error($dbHandle);
}


// Create Comments Table
$res = pg_query($dbHandle, "CREATE TABLE IF NOT EXISTS comments (
    id SERIAL PRIMARY KEY,
    post_id INT REFERENCES posts(id) ON DELETE CASCADE,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    comment TEXT,
    comment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);");

if (!$res) {
    echo "An error occurred.\n";
    echo pg_last_error($dbHandle);
}

// Create Likes Table
$res = pg_query($dbHandle, "CREATE TABLE IF NOT EXISTS post_likes (
    id SERIAL PRIMARY KEY,
    post_id INT REFERENCES posts(id) ON DELETE CASCADE,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    liked_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (post_id, user_id) -- Ensuring one like per user per post
);");

if (!$res) {
    echo "An error occurred.\n";
    echo pg_last_error($dbHandle);
}


// Create Shares Table
$res = pg_query($dbHandle, "CREATE TABLE IF NOT EXISTS post_shares (
    id SERIAL PRIMARY KEY,
    post_id INT REFERENCES posts(id) ON DELETE CASCADE,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    shared_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (post_id, user_id) -- Ensuring one share per user per post
);");

if (!$res) {
    echo "An error occurred.\n";
    echo pg_last_error($dbHandle);
}


echo "Database setup complete.\n";


$users = [
    "INSERT INTO users (username, password) VALUES ('user1', 'password1');",
    "INSERT INTO users (username, password) VALUES ('user2', 'password2');"
];

foreach ($users as $query) {
    pg_query($dbHandle, $query);
}

// Songs
$songs = [
    "INSERT INTO songs (title, artist, album, release_date, genre) VALUES ('Song 1', 'Artist 1', 'Album 1', '2023-01-01', 'Pop');",
    "INSERT INTO songs (title, artist, album, release_date, genre) VALUES ('Song 2', 'Artist 2', 'Album 2', '2023-02-01', 'Rock');"
];

foreach ($songs as $query) {
    pg_query($dbHandle, $query);
}

// Posts
$posts = [
    "INSERT INTO posts (post_title, user_id, song_id, content) VALUES ('new song by drake!', 1, 1, 'Loving this new song!');",
    "INSERT INTO posts (post_title, user_id, song_id, content) VALUES ('check out michael jackson', 2, 2, 'This track is amazing!');"
];

foreach ($posts as $query) {
    pg_query($dbHandle, $query);
}

echo "Database setup with new filler data complete.\n";
?>

