<?php
include 'database.php';

if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];

    $sql = "DELETE FROM user_data WHERE id = $id";
    $result = mysqli_query($con, $sql);

    if ($result) {
        header("Location: display.php");
        exit();
    } else {
        echo "Error something happened";
    }
} 
?>
