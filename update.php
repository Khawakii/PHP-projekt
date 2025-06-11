<?php
include 'Authenticate.php';
include 'database.php';

$auth = new Authenticate($con);
$auth->requireLogin();
$auth->requireAdmin();

$message = "";
$alertType = "success";

// Check for update ID
if (isset($_GET['update_id'])) {
    $id = intval($_GET['update_id']);

    $sql = "SELECT * FROM user_data WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $name = $row['name'];
        $email = $row['email'];
        $comment = $row['comment'];
    } else {
        $message = "User not found.";
        $alertType = "danger";
    }
}

// Handle update submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $comment = $_POST['comment'] ?? '';

    if (empty($name) || empty($email)) {
        $message = "Name and email cannot be empty.";
        $alertType = "danger";
    } else {
        $sql = "UPDATE user_data SET name = ?, email = ?, comment = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $comment, $id);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            $message = "User updated successfully.";
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
    <title>Update User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- header -->
<header class="bg-white border-bottom py-3 mb-4">
    <div class="container d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Update User</h4>
        <a href="display.php" class="btn btn-secondary">Back to List</a>
    </div>
</header>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?= $alertType; ?>"><?= htmlspecialchars($message); ?></div>
                <?php endif; ?>

                <?php if (isset($name)): ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($name); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment:</label>
                        <textarea class="form-control" id="comment" name="comment" rows="4" placeholder="Write your comment..."><?= htmlspecialchars($comment); ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" name="submit" class="btn btn-primary">Update User</button>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
