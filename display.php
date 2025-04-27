<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
<?php 
include 'database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel</title>
</head>
<body>
<div class="container">
    <a href="admin.php" class="btn btn-primary my-5">Add user</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Comment</th>
                <th scope="col">Button</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $sql = "SELECT * FROM user_data";
            $result = mysqli_query($con, $sql);
            if($result){
                while($row = mysqli_fetch_assoc($result)){
                    $id = $row['id'];
                    $name = $row['name'];
                    $email = $row['email'];
                    $comment = $row['comment'];
                    echo '<tr>
                        <th scope="row">'.$id.'</th>
                        <td>'.$name.'</td>
                        <td>'.$email.'</td>
                        <td>'.$comment.'</td>
                        <td>
                            <a href="delete.php?id='.$id.'" class="btn btn-danger text-light">Delete</a>
                            <a href="update.php?update_id='.$id.'" class="btn btn-success text-light">Update</a>
                        </td>
                    </tr>';
                }
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>