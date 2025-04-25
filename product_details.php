<?php
session_start();
include "navbar.php";

if(!isset($_SESSION['name'])) {
    header("location:signin.php");
    exit;
}

$id = $_GET['id'];

$row = $onerecord->fetchOneProduct($id);

$name = $row['name'];
$description = $row['description'];
$price = $row['price'];
$discount = $row['discount'];
$totalPrice = $price - $discount;
$quantity = $row['quantity'];
$image = $row['image'] ?: 'no_image_icon_23500.jpg';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product Details</title>
   <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>


<div class="container mt-5">
<div class="text-start mb-4">
                <a href="index.php" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Home
                </a>
            </div>
    <h2 class="text-center">Product Details</h2>
    <div class="row">
        <div class="col-md-6">
            <img src="Products/<?php echo $image; ?>" width="400px" height="500px">
        </div>
        <div class="col-md-6">
            <h3><?php echo $name; ?></h3>
            
            <h4>
                <?php if ($discount > 0): ?>
                    ₹<?php echo $totalPrice; ?> <del class="text-muted">₹<?php echo $price; ?></del>
                <?php else: ?>
                    ₹<?php echo $price; ?>
                <?php endif; ?>
            </h4>

            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <div class="input-group">
                    <div class="input-group-prepend"><button class="btn btn-dark qtyminus">-</button></div>
                    <input type="text" id="quantity" name="quantity" value="1" class="form-control text-center qty">
                    <div class="input-group-append"><button class="btn btn-dark qtyplus">+</button></div>
                </div>
            </div>

            <input type="hidden" id="price" value="<?php echo $totalPrice; ?>">
            <input type="hidden" id="product_id" value="<?php echo $row['id']; ?>">

            <button>
            <a href="#" class="" id="cart">Add to Cart</a></button>
           <button><a href="#" class="">Buy Now</a></button> 

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="cart.js"></script>
<script>
    $(".qtyminus").on("click", function(){
        var qty = parseInt($(".qty").val());
        if (qty > 1) $(".qty").val(qty - 1);
    });

    $(".qtyplus").on("click", function(){
        var qty = parseInt($(".qty").val());
        $(".qty").val(qty + 1);
    });
</script>
</body>
</html>
