<?php
include 'Authenticate.php';
include 'database.php';

$auth = new Authenticate($con);
$auth->requireLogin();
$auth->requireAdmin();

$message = "";
$alertType = "success";

$id = $_GET['update_id'] ?? 0;
$username = "";

// Betöltés szerkesztéshez
if ($id) {
    $stmt = mysqli_prepare($con, "SELECT * FROM admin WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    if ($user) {
        $username = $user['username'];
    } else {
        $message = "Admin not found.";
        $alertType = "danger";
    }
}

// Frissítés feldolgozása
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    $newUsername = trim($_POST['username']);
    $newPassword = $_POST['password'];

    if (empty($newUsername)) {
        $message = "Username cannot be empty.";
        $alertType = "danger";
    } else {
        if (!empty($newPassword)) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($con, "UPDATE admin SET username = ?, password = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "ssi", $newUsername, $hashedPassword, $id);
        } else {
            $stmt = mysqli_prepare($con, "UPDATE admin SET username = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "si", $newUsername, $id);
        }

        if (mysqli_stmt_execute($stmt)) {
            header("Location: newAdmin.php");
            exit;
        } else {
            $message = "Error updating admin: " . mysqli_error($con);
            $alertType = "danger";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<header class="bg-white border-bottom py-3 mb-4">
  <div class="container d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Update Admin</h4>
    <a href="newAdmin
.php" class="btn btn-secondary">Back to List</a>
  </div>
</header>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm p-4">

        <?php if (!empty($message)) : ?>
          <div class="alert alert-<?= $alertType; ?>">
            <?= htmlspecialchars($message); ?>
          </div>
        <?php endif; ?>

        <?php if ($id && $user): ?>
        <form method="POST">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" class="form-control" required value="<?= htmlspecialchars($username); ?>">
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">New Password (leave blank to keep current)</label>
            <input type="password" id="password" name="password" class="form-control">
          </div>

          <div class="d-flex justify-content-end">
            <button type="submit" name="submit" class="btn btn-primary">Update Admin</button>
          </div>
        </form>
        <?php else: ?>
          <p class="text-danger">Invalid admin ID.</p>
        <?php endif; ?>

      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
