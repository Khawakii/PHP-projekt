<?php
include 'Authenticate.php';
include 'database.php';

// Authentication

$auth = new Authenticate($con);
$auth->requireLogin();
$auth->requireAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Display Users</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<header class="bg-white border-bottom py-3 mb-4">
  <div class="container d-flex justify-content-between align-items-right">
    <h4 class="mb-0">User List</h4>

     <div>
      <a href="newAdmin.php" class="btn btn-info me-2">New Admin</a>
      <a href="
display.php" class="btn btn-info me-2">User's Data</a>
        <a href="logout.php" class="btn btn-danger">Log Out</a>
  </div>
</header>

<div class="container">
  <div class="card shadow-sm p-4">
    <h5 class="mb-4">All Registered Users</h5>
    <div>
    <a href="admin.php" class="btn btn-primary">Add New User</a> </div>
    <br>

    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Comment</th>
          <th colspan="2" class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $sql = "SELECT * FROM user_data";
        $result = mysqli_query($con, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $name = $row['name'];
                $email = $row['email'];
                $comment = $row['comment'];
                echo '
                <tr>
                    <td>'.$id.'</td>
                    <td>'.htmlspecialchars($name).'</td>
                    <td>'.htmlspecialchars($email).'</td>
                    <td>'.htmlspecialchars($comment).'</td>
                    <td class="text-center">
                        <a href="update.php?update_id='.$id.'" class="btn btn-success btn-sm">Update</a>
                    </td>
                    <td class="text-center">
                        <a href="delete.php?delete_id='.$id.'" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete it?\')">Delete</a>
                    </td>
                </tr>';
            }
        } else {
            echo '<tr><td colspan="6" class="text-center text-muted">No data found.</td></tr>';
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
