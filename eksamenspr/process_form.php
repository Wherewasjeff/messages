<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    $date = date("Y-m-d"); // Get current date

    $sql = "INSERT INTO messages (name, email, message, date) VALUES ('$name', '$email', '$message', '$date')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Message submitted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }

    $conn->close();
}
?>
