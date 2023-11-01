<!-- Authors: Daniel Huynh (tap7ke) and Alex Fetea (pvn5nv) -->

<?php

// Check if song details are set in the session
if (isset($_SESSION['songDetailsJson'])) {
    $songDetails = json_decode($_SESSION['songDetailsJson']); // Decode JSON to an object
    // Clear the session variable after use
    unset($_SESSION['songDetailsJson']);
} else {
    $songDetails = null;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Song Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Song Details</h1>
            </div>
            <div class="card-body">
                <?php if ($songDetails): ?>
                    <p class="card-text"><strong>Title:</strong> <?php echo $songDetails->title ?? 'N/A'; ?></p>
                    <p class="card-text"><strong>Artist:</strong> <?php echo $songDetails->artist ?? 'N/A'; ?></p>
                    <!-- Display other song details as needed -->
                <?php else: ?>
                    <p>No song details available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and its dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
