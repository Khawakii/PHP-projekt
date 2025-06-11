<?php

include 'Authenticate.php';  
include 'database.php';  

$auth = new Authenticate($con); 
$auth->logout();  


header('Location: login.php');
exit;
?>
