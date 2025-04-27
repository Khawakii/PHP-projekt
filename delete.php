<?php 
include 'database.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM user_data WHERE id = $id";
    $result = mysqli_query($con, $sql);
    if($result){
        header('location: display.php');
    }else{
        die(mysqli_error($con));
    }
}


?>