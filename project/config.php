<?php
$conn = mysqli_connect("localhost", "username", "password", "shop_db");

if(!$conn){
   die("Connection failed: " . mysqli_connect_error());
}

// Set character set to UTF-8 for proper encoding
mysqli_set_charset($conn, "utf8mb4");
?>