<?php
$host = "db";
$port = "5432";
$database = "music_app";
$user = "localuser";
$password = "your_password"; 

$dbHandle = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");

if ($dbHandle) {
    echo "Success connecting to database\n";
} else {
    echo "An error occurred connecting to the database\n";
    exit;
}

// Create Users Table
$res = pg_query($dbHandle, "CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password TEXT NOT NULL,
    join_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);");

// Create Songs Table
$res = pg_query($dbHandle, "CREATE TABLE IF NOT EXISTS songs (
    id SERIAL PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    artist VARCHAR(100) NOT NULL,
    album VARCHAR(100),
    release_date DATE,
    genre VARCHAR(50)
);");

// Create Posts Table
$res = pg_query($dbHandle, "CREATE TABLE IF NOT EXISTS posts (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    song_id INT REFERENCES songs(id) ON DELETE SET NULL,
    content TEXT,
    post_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);");

// Create Comments Table
$res = pg_query($dbHandle, "CREATE TABLE IF NOT EXISTS comments (
    id SERIAL PRIMARY KEY,
    post_id INT REFERENCES posts(id) ON DELETE CASCADE,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    comment TEXT,
    comment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);");

// Create Likes Table
$res = pg_query($dbHandle, "CREATE TABLE IF NOT EXISTS likes (
    id SERIAL PRIMARY KEY,
    post_id INT REFERENCES posts(id) ON DELETE CASCADE,
    user_id INT REFERENCES users(id) ON DELETE CASCADE
);");

// Create Shares Table
$res = pg_query($dbHandle, "CREATE TABLE IF NOT EXISTS shares (
    id SERIAL PRIMARY KEY,
    post_id INT REFERENCES posts(id) ON DELETE CASCADE,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    share_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);");

echo "Database setup complete.\n";
?>

