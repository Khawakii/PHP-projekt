<?php
include 'Authenticate.php';
include 'database.php';

$auth = new Authenticate($con);
$auth->requireLogin();
$auth->requireAdmin();

if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);

    $sql = "DELETE FROM admin WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        // Sikeres törlés
        header("Location: newAdmin.php?deleted=1");
        exit;
    } else {
        // Hiba
        echo "Hiba történt a törlés során: " . mysqli_error($con);
    }
} else {
    // Ha nincs ID megadva
    header("Location: newAdmin.php");
    exit;
}
