<?php 
$con = mysqli_connect('localhost', 'root', '', 'travel');

if($con){echo "";}
else{die(mysqli_error($con));}


?>