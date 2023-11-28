<!-- https://cs4640.cs.virginia.edu/tap7ke/music-app/index.html -->
<!-- Authors: Daniel Huynh (tap7ke) and Alex Fetea (pvn5nv) -->


<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

spl_autoload_register(function ($classname) {

    
    $filename = "/opt/src/music-social-media/$classname.php";
    if (file_exists($filename)) {
        include $filename;
    }
});

spl_autoload_register(function ($classname) {
    $filename = "/students/tap7ke/students/tap7ke/src/controllers/$classname.php";
    if (file_exists($filename)) {
        include $filename;
    }
});



$controller = new MusicAppController($_GET);
$controller->run();

?>