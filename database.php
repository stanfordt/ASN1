<?php
    $servername = 'localhost';
    // Updated user to ts_user, generic account
    $username = 'db_user';
    $password = 'pa55word';
    $dbname = 'classSearch';

    // Create connection
    $db = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
?>