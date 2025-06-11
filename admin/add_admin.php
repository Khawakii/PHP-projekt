<?php
include 'Authenticate.php';
include 'database.php';

$auth = new Authenticate($con);
$auth->requireLogin();
$auth->requireAdmin();

$message = "";
$alertType = "success";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $message = "Username and password cannot be empty.";
        $alertType = "danger";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO admin (username, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        // ss = string type
        mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPassword);

        if (mysqli_stmt_execute($stmt)) {
            $message = "Admin added successfully.";
            $alertType = "success";
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
    <title>Add Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<header class="bg-white border-bottom py-3 mb-4">
    <div class="container d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Add New Admin</h4>
        <a href="newAdmin.php" class="btn btn-secondary">Back to List</a>
    </div>
</header>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?= $alertType; ?>"><?= htmlspecialchars($message); ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" name="submit" class="btn btn-success">Add Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
