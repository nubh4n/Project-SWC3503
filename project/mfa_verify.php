<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['mfa_verified'])) {
    header('location: login.php');
    exit();
}

if (isset($_POST['verify_code'])) {
    $verify_code = mysqli_real_escape_string($conn, $_POST['verify_code']);

    // Validate the verification code
    if ($verify_code == $_SESSION['verification_code']) {
        $_SESSION['mfa_verified'] = true;
        header('location: home.php');
    } else {
        $message[] = 'Incorrect verification code!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>MFA Verification</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<div class="form-container">
   <form action="" method="post">
      <h3>MFA Verification</h3>
      <p>Enter the verification code sent to your email:</p>
      <input type="text" name="verify_code" placeholder="Verification Code" required class="box">
      <input type="submit" value="Verify" class="btn">
   </form>
</div>

<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '
      <div class="message">
         <span>'.$msg.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
    }
}
?>

</body>
</html>