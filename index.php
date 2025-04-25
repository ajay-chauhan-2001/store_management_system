<?php
session_start();
 include "navbar.php";


if(!isset($_SESSION['name']))
{
    header("location:signin.php");
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ecommerce</title>

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<style>
    p,.error {
        color: red;
    }
    .grid-container {
  display: grid;
  grid-template-columns: auto auto auto auto;
  grid-gap: 10px;
  padding: 10px;
}

.grid-container > div {
  background-color: rgba(255, 255, 255, 0.8);
  text-align: center;
  padding: 0px 0;
  font-size: 30px;
}

.card{

    /* padding-bottom: 8px; */
    padding-top: 0px;
} 
</style>
<body>


<div class="grid-container">

        <?php         
            // $fetchData = new User($conn); // create object Admin class
            $products = $onerecord->fetchAllProduct();  // get all products
            $i = 1;
           
            foreach($products as $row)
            {
               $productId = $row['id'];
                $productPrice=$row['price'];
                $productDiscount=$row['discount'];
                $totalPrice=$row['price']-$row['discount'];
        ?>
            <div class="card">
            <!-- <a href="product_details.php"> -->
            <a href="product_details.php?id=<?php echo $productId; ?>" class="card-link">
            <br> <img src="Products/<?php echo $row['image'] ? $row['image'] : 'no_image_icon_23500.jpg'; ?>" width="80px" height="100px"><br>
            <?php echo $row['name']."<br>"; ?>

            <?php if ($productDiscount == 0): ?>
                <?php echo "₹".$productPrice; ?>

            <?php else: ?>
                   
                <button type="button" class="btn btn-danger">
                <span > <?php echo "₹". $productDiscount." off"; ?>
                </button>
                <del> <?php echo "₹".$productPrice; ?></del>
                <?php echo "₹".$totalPrice; ?>
            <?php endif; ?>
                          
            </a>
            </div>
          
        <?php
            }
        ?>   
</div>

</body>
</html>

