<?php
// Authors: Daniel Huynh (tap7ke) and Alex Fetea (pvn5nv)

$host = "localhost";
$port = "5432";
$database = "tap7ke";
$user = "tap7ke";
$password = "GJV3AaVcIgxE"; 

$dbHandle = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");

if ($dbHandle) {
    echo "Success connecting to database<br>";
} else {
    echo "An error occurred connecting to the database<br>";
}

// Drop Existing Tables
$dropTables = [
    "DROP TABLE IF EXISTS user_community;",
    "DROP TABLE IF EXISTS post_shares;",
    "DROP TABLE IF EXISTS post_likes;",
    "DROP TABLE IF EXISTS comments;",
    "DROP TABLE IF EXISTS posts;",
    "DROP TABLE IF EXISTS communities;",
    "DROP TABLE IF EXISTS songs;",
    "DROP TABLE IF EXISTS users;"
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

// Create communities Table
$res = pg_query($dbHandle, "CREATE TABLE IF NOT EXISTS communities (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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
    community_id INT REFERENCES communities(id) ON DELETE SET NULL,
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



$res = pg_query($dbHandle, "CREATE TABLE IF NOT EXISTS user_community (
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    community_id INT REFERENCES communities(id) ON DELETE CASCADE,
    joined_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, community_id)
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


// Create Sample Communities
$communities = [
    "INSERT INTO communities (name, description) VALUES ('Music Lovers', 'A community for people who love music.');",
    "INSERT INTO communities (name, description) VALUES ('Songwriters', 'A community for songwriters to share and discuss.');"
];

foreach ($communities as $query) {
    $result = pg_query($dbHandle, $query);
    if (!$result) {
        echo "An error occurred while inserting communities.\n";
        echo pg_last_error($dbHandle);
    }
}

// Songs
$songs = [
    "INSERT INTO songs (title, artist, album, release_date, genre) VALUES ('Hotline Bling', 'Drake', 'Views', '2015-07-31', 'Pop, R&B');",
    "INSERT INTO songs (title, artist, album, release_date, genre) VALUES ('Thriller', 'Michael Jackson','Thriller', '1982-11-29', 'Disco, Funk');"
];

foreach ($songs as $query) {
    pg_query($dbHandle, $query);
}

// Posts
$posts = [
    "INSERT INTO posts (post_title, user_id, song_id, content, community_id) VALUES ('New song by Drake!', 1, 1, 'Loving this new song!', 1);",
    "INSERT INTO posts (post_title, user_id, song_id, content, community_id) VALUES ('Check out Michael Jackson', 2, 2, 'This track is amazing!', 2);"
];

foreach ($posts as $query) {
    $result = pg_query($dbHandle, $query);
    if (!$result) {
        echo "An error occurred while inserting posts.\n";
        echo pg_last_error($dbHandle);
    }
}

echo "Database setup with new filler data complete.\n";
echo "Includes songs by Michael Jackson and Drake.\n";
?>

