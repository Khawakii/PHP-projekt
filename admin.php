<?php
include 'database.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $comment = $_POST['comment'];

    // Validáció
    if (empty($name) || empty($email)) {
        echo "Name and email are required fields.";
    } else {
        // Adat beszúrás
        $query = "INSERT INTO user_data (name, email, comment) VALUES ('$name', '$email', '$comment')";
        $result = mysqli_query($con, $query);

        if ($result) {
            echo "User added successfully.";
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
}
?>

<!-- FORM -->
<form method="POST">
  <fieldset>
    <legend>Personal Info</legend>

    Name: <input type="text" name="name" required><br><br>
    Email: <input type="email" name="email" required><br><br>

    Comment:<br>
    <textarea id="comment" name="comment" rows="4" cols="50" placeholder="Írhatsz megjegyzést, ha szeretnél..."></textarea><br><br>

    <input type="submit" name="submit" value="Add User">
  </fieldset>
</form>
