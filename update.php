<?php
include 'database.php';

// Ellenőrzés: van-e update_id az URL-ben
if (isset($_GET['update_id'])) {
    $id = $_GET['update_id'];

    // Lekérjük a felhasználó adatait
    $sql = "SELECT * FROM user_data WHERE id=$id";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    $name = $row['name'];
    $email = $row['email'];
    $comment = $row['comment'];
}

// Ellenőrzés: van-e POST kérés a frissítéshez
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $comment = $_POST['comment'];

    $sql = "UPDATE user_data SET name='$name', email='$email', comment='$comment' WHERE id=$id";
    $result = mysqli_query($con, $sql);

    if ($result) {
      echo"user updated successfully";
        
       
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!-- HTML kezdete -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Update User Information</h2>

    <form method="POST" class="card p-4 shadow rounded-4">
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">Comment:</label>
            <textarea class="form-control" id="comment" name="comment" rows="4" placeholder="Write your comment..."><?php echo htmlspecialchars($comment); ?></textarea>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Update User</button>
       
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
