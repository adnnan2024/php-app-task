<?php
function connectDB() {
    $servername = "mysql:3306";
    $username = "user";
    $password = "userpassword"; 
    $dbname = "testdb";

    // Connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    return $conn;
}
?>
