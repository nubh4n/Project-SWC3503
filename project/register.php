<?php
include 'config.php';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);
    $cpass = mysqli_real_escape_string($conn, $_POST['cpassword']);
    $user_type = $_POST['user_type'];
    $mfa_enabled = isset($_POST['mfa_enabled']) ? 1 : 0; // Check if MFA checkbox is checked

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $message[] = 'User already exists!';
    } else {
        if ($pass != $cpass) {
            $message[] = 'Confirm password not matched!';
        } else {
            $hashed_pass = password_hash($cpass, PASSWORD_BCRYPT); // Hash the password
            mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type, mfa_enabled) VALUES('$name', '$email', '$hashed_pass', '$user_type', '$mfa_enabled')") or die('query failed');
            $message[] = 'Registered successfully!';
            header('location: login.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .checkbox-container {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .checkbox-container input[type="checkbox"] {
            margin-right: 10px;
        }
        .checkbox-container label {
            margin: 0;
        }
    </style>
</head>
<body>

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

<div class="form-container">
    <form action="" method="POST">
        <h3>Register now</h3>
        <input type="text" name="name" placeholder="Enter your name" required class="box">
        <input type="email" name="email" placeholder="Enter your email" required class="box">
        <input type="password" name="password" placeholder="Enter your password" required class="box">
        <input type="password" name="cpassword" placeholder="Confirm your password" required class="box">
        <select name="user_type" class="box">
            <option value="user">user</option>
            <option value="admin">admin</option>
        </select>
        <div class="checkbox-container">
            <input type="checkbox" name="mfa_enabled" id="mfa_enabled">
            <label for="mfa_enabled">Enable Multi-Factor Authentication</label>
        </div>
        <input type="submit" name="submit" value="register now" class="btn">
        <p>Already have an account? <a href="login.php">Login now</a></p>
    </form>
</div>

</body>
</html>