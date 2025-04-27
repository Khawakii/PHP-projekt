<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['Name']);
    $phone = htmlspecialchars($_POST['Number']);
    $guests = htmlspecialchars($_POST['Guests']);
    $date = htmlspecialchars($_POST['date']);
    $destination = htmlspecialchars($_POST['Destination']);


    echo "<h2>Your Reservation Details</h2>";
    echo "Name: " . $name . "<br>";
    echo "Phone: " . $phone . "<br>";
    echo "Number of Guests: " . $guests . "<br>";
    echo "Check-in Date: " . $date . "<br>";
    echo "Destination: " . $destination . "<br>";
}
?>
