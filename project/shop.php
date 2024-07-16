<?php
include 'config.php';
session_start();

if(!isset($_SESSION['user_id'])){
   header('location: login.php');
   exit();
}

$user_id = $_SESSION['user_id'];

$stmt = mysqli_prepare($conn, "SELECT * FROM `products`");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shop</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Our Shop</h3>
   <p><a href="home.php">Home</a> / Shop</p>
</div>

<section class="products">
   <h1 class="title">Latest Products</h1>
   <div class="box-container">
      <?php while($fetch_products = mysqli_fetch_assoc($result)): ?>
      <form action="" method="post" class="box">
         <img class="image" src="uploaded_img/<?php echo htmlspecialchars($fetch_products['image']); ?>" alt="">
         <div class="name"><?php echo htmlspecialchars($fetch_products['name']); ?></div>
         <div class="price">RM<?php echo htmlspecialchars($fetch_products['price']); ?></div>
         <input type="number" min="1" name="product_quantity" value="1" class="qty">
         <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($fetch_products['name']); ?>">
         <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($fetch_products['price']); ?>">
         <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($fetch_products['image']); ?>">
         <input type="submit" value="Add to Cart" name="add_to_cart" class="btn">
      </form>
      <?php endwhile; ?>
   </div>
</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>