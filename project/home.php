<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
    exit(); // Ensure script stops execution after redirection
}

// Function to sanitize user input
function sanitizeInput($conn, $input) {
    return mysqli_real_escape_string($conn, htmlspecialchars($input));
}

// Function to sanitize output for display
function sanitizeOutput($output) {
    return htmlspecialchars($output);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home Page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'header.php'; ?>

<div class="heading">
   <h3>Welcome, <?php echo sanitizeOutput($_SESSION['user_name']); ?></h3>
   <p> <a href="home.php">home</a> / profile </p>
</div>

<section class="profile">

   <h1 class="title">Your Profile</h1>

   <div class="box-container">
      <div class="box">
         <p> Name: <span><?php echo sanitizeOutput($_SESSION['user_name']); ?></span> </p>
         <p> Email: <span><?php echo sanitizeOutput($_SESSION['user_email']); ?></span> </p>
         <p> User ID: <span><?php echo sanitizeOutput($_SESSION['user_id']); ?></span> </p>
      </div>
   </div>

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>