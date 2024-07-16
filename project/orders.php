<?php
include 'config.php';
session_start();

if(!isset($_SESSION['user_id'])){
   header('location: login.php');
   exit();
}

$user_id = $_SESSION['user_id'];

// Retrieve user orders
$stmt = mysqli_prepare($conn, "SELECT * FROM `orders` WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
   <h2>Your Orders</h2>
   <table>
      <thead>
         <tr>
            <th>Order ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Total Price</th>
            <th>Placed On</th>
            <th>Payment Status</th>
         </tr>
      </thead>
      <tbody>
         <?php while($order = mysqli_fetch_assoc($result)): ?>
         <tr>
            <td><?php echo htmlspecialchars($order['id']); ?></td>
            <td><?php echo htmlspecialchars($order['name']); ?></td>
            <td><?php echo htmlspecialchars($order['email']); ?></td>
            <td><?php echo htmlspecialchars($order['total_price']); ?></td>
            <td><?php echo htmlspecialchars($order['placed_on']); ?></td>
            <td><?php echo htmlspecialchars($order['payment_status']); ?></td>
         </tr>
         <?php endwhile; ?>
      </tbody>
   </table>
</div>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>