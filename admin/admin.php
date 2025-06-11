<?php
include 'Authenticate.php';
include 'database.php';

$auth = new Authenticate($con);
$auth->requireLogin();
$auth->requireAdmin();

$message = "";
$alertType = "success";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $comment = $_POST['comment'];

    if (empty($name) || empty($email)) {
        $message = "Name and email are required fields.";
        $alertType = "danger";
    } else {
        $query = "INSERT INTO user_data (name, email, comment) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $comment);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            $message = "User added successfully.";
        } else {
            $message = "Error: " . mysqli_error($con);
            $alertType = "danger";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Fejléc -->
<header class="bg-white border-bottom py-3 mb-4">
  <div class="container d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Add New User</h4>
    <div>
      <a href="newAdmin.php" class="btn btn-info me-2">New Admin</a>
      <a href="
display.php" class="btn btn-info me-2">User's Data</a>
      <a href="
logout.php" class="btn btn-danger">Log Out</a>
    </div>
  </div>
</header>


<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6"> 
      <div class="card shadow-sm p-4">
        <h5 class="mb-4">User Registration</h5>

        <?php if (!empty($message)): ?>
          <div class="alert alert-<?= $alertType; ?>" role="alert">
            <?= $message; ?>
          </div>
        <?php endif; ?>

        <form method="POST">
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="comment" class="form-label">Comment</label>
            <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Írhatsz megjegyzést, ha szeretnél..."></textarea>
          </div>

          <button type="submit" name="submit" class="btn btn-success">Add User</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
