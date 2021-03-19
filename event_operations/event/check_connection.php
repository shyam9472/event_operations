<?php
function check_db() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = 'tatvasoft';
    
    $conn = mysqli_connect($servername, $username, $password, $db);
    
    if(!$conn) {
        die('Connection Error');
    }

    return $conn;
}