<?php
$servername = "localhost";
$username = "projadmin";
$password = "0001";
$datebase = "sushi";

// Create connection
$conn = new mysqli($servername, $username, $password, $datebase);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";
$conn->set_charset('utf8');
?>