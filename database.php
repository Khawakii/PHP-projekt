<?php
$host = 'localhost'; 
$user = 'root'; 
$password = ''; 
$dbname = 'travel'; 

$con = mysqli_connect($host, $user, $password, $dbname); // con ->datab

if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}
?>
