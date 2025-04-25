<?php
session_start();
include "order_function.php";

if(!isset($_SESSION['name'])) {
    header("location:../login.php");
}
$admin = new Admin($conn);  // create object Admin class

// Initialize variables for form data
$name = $description = $price = $discount = $quantity = $category_id = $image = "";
$nameError = $descriptionError = $priceError = $discountError = $quantityError = $category_idError = $imageError = "";


  $id = $_GET['id'];
$onerecord = new Admin($conn);
// get order details
$row = $onerecord->fetchOneOder($id);
// print_r($row);
// die();
 $customerId = $row['customer_id'];
  $total = $row['total_amount'];
 $status = $row['status'];
$created_at = $row['created_at'];
$quantity = $row['quantity'];

// get User Details
$userRow = $onerecord->fetchOneUser($id);
 $name = $userRow['name'];
 $email = $userRow['email'];
 $phoneNumber = $userRow['phone_number'];
 $image = $userRow['image'];
 $address = $userRow['address'];



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newStatus = $_POST['status'];
 
    try {
        $updateSql = $admin->updateOrder($id,$newStatus,$totalAmount);
        
        if ($updateSql) {
            $statusMessage = "Order status updated successfully!";
           
        } else {
            $errorMessage = "Product not updated.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Edit Product</title>
    
</head>

<body>
    <button><a href="orders.php">Back to Order</a></button>
    <h1>Order Details</h1>

    <div class="container px-4 text-left">
  <div class="row gx-5">
    
    <div class="col">
     
     <!-- order items -->
      <div class="card">
        
      <div class="p-3">
        <p>Order Id :
            <?php echo $id; 
            echo "<br>";
            echo $created_at;
             ?>
        </p>
     </div>
     <div class="p-3">
        <p>Status :
            <?php echo $status; 
           
             ?>
        </p>
     </div>

    <!-- order item list -->
      <div class="p-3">
      <table class="table">
      <thead>
            <tr>
                <td>Sr</td>
                <td>Product Details</td>
                <td>Price</td>
                <td>Discount</td>
                <td>Total Amount</td>
                          
            </tr>
        </thead>
        <tbody>
        <?php         
            $fetchData = new Admin($conn); // create object Admin class
            $products = $fetchData->fetchAllOrderItem($id);  // get all products
            $i = 1;        
           
            foreach($products as $row)
            {
                $productPrice = $row['price'] * $row['quantity'];
                $productDiscount = $row['discount'] * $row['quantity'];
                $totalProductPrice += $productPrice;
                $totalDiscount += $productDiscount;
                $totalAmount += $productPrice - $productDiscount;

        ?>
            <tr>
                <td><?php echo $i++; ?></td>


                <td>
                    
                    <img src="../Products/<?php echo $row['image'] ? $row['image'] : 'no_image_icon_23500.jpg'; ?>" width="80px" height="80px">                          
                    <br>
                    <?php 

                                        
                    echo " Name : ". $row['name']."<br>"; 
                    echo " Qty :  ". $row['quantity']."<br>";
                    echo " Price : ₹".$row['price']; ?>
                </td>
                <td>
                    <?php echo $row['price'] * $row['quantity']; ?>
                </td>
                <td>
                    <?php echo $row['discount'] * $row['quantity']; ?>
                </td>
                <td>
                    <?php echo ($row['price'] * $row['quantity']) - ($row['discount'] * $row['quantity']); ?>
                </td>

              

                
                
            </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
    <hr>
    <!-- total item orders -->
    <?php echo "Product Price : ₹". $totalProductPrice."<br>"; ?>
    <?php echo "Product Discount : ₹". $totalDiscount."<br>"; ?>
    <td><?php echo "Total : ₹". $totalAmount; ?></td>

    
       
     </div>
      </div>
    
    </div>

    
    

    <!-- order status change -->
       <form action="" method="POST">

     <div class="col">
        <h5>Change Order Status</h5>
        <select name="status" id="status" onchange="this.form.submit()">
            <option value="Pending" <?php echo ($status == 'Pending') ? 'selected' : ''; ?>>Pending</option>
            <option value="Completed" <?php echo ($status == 'Completed') ? 'selected' : ''; ?>>Completed</option>
            <option value="Canceled" <?php echo ($status == 'Canceled') ? 'selected' : ''; ?>>Canceled</option>
        </select> <br>
            <br>

            <!-- customer infomation -->
            <div class="card">
                <div class="p-3">
                    <h5>Customer Infornation</h5>
                    <img src="../Customer/<?php echo $userRow['image'] ? $userRow['image'] : 'no_image_icon_23500.jpg'; ?>" width="80px" height="80px">                          
                    <br>
                    <?php 
                                             

                        // echo "Image : ". $image."<br>";
                        echo "Name : ". $name."<br>";
                        echo "Email : ".$email."<br>";
                        echo "Phone Number : ".$phoneNumber;

                    ?>


                </div>

            </div><br>

            <!-- shipping Address -->
            <div class="card">
                <div class="p-3">
                    <h5>Shipping Address</h5>
                    
                    <?php 
                                             

                        // echo "Image : ". $image."<br>";
                        echo "Address : ". $address."<br>";
                       

                    ?>


                </div>

            </div>
    
     </div>
    </form>

    
    
  </div>
</div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/additional-methods.min.js"></script>

</html>
<script>
   $('form select').on('change', function(){
    $(this).closest('form').submit();
});
</script>