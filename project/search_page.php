<?php
include 'config.php';
session_start();

if(!isset($_SESSION['user_id'])){
   header('location: login.php');
   exit();
}

$user_id = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Search Products</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Search Products</h3>
   <p><a href="home.php">Home</a> / Search</p>
</div>

<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search" placeholder="Search products..." class="box">
      <input type="submit" name="submit" value="Search" class="btn">
   </form>
</section>

<section class="products">
   <div class="box-container">
      <?php
      if(isset($_POST['submit'])){
         $search_item = filter_var($_POST['search'], FILTER_SANITIZE_STRING);

         $stmt = mysqli_prepare($conn, "SELECT * FROM `products` WHERE name LIKE ?");
         $search_query = '%' . $search_item . '%';
         mysqli_stmt_bind_param($stmt, "s", $search_query);
         mysqli_stmt_execute($stmt);
         $result = mysqli_stmt_get_result($stmt);

         if(mysqli_num_rows($result) > 0){
            while($fetch_product = mysqli_fetch_assoc($result)){
               ?>
               <form action="" method="post" class="box">
                  <img src="uploaded_img/<?php echo htmlspecialchars($fetch_product['image']); ?>" alt="" class="image">
                  <div class="name"><?php echo htmlspecialchars($fetch_product['name']); ?></div>
                  <div class="price">RM<?php echo htmlspecialchars($fetch_product['price']); ?></div>
                  <input type="number" class="qty" name="product_quantity" min="1" value="1">
                  <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($fetch_product['name']); ?>">
                  <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($fetch_product['price']); ?>">
                  <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($fetch_product['image']); ?>">
                  <input type="submit" class="btn" value="Add to Cart" name="add_to_cart">
               </form>
               <?php
            }
         } else {
            echo '<p class="empty">No result found!</p>';
         }
      } else {
         echo '<p class="empty">Search something!</p>';
      }
      ?>
   </div>
</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>