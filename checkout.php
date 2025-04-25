<?php
session_start();
include "navbar.php";


if(!isset($_SESSION['name']))
{
    header("location:signin.php");
}

 $id = $_SESSION['all']['id'] ?? 0;

$products = $onerecord->fetchAllCart($id);
  $customer_id=$id;

  $totalProductPrice = 0;
  $totalDiscount = 0;
  $totalAmount = 0;

$value=$onerecord->fetchAllCartRecord($id,$user_id,$session_id);

 foreach($value as $row):
  $unitPrice = $row['price'] - $row['discount'];
  $total = $unitPrice * $row['quantity'];
  $totalProductPrice += $row['price'] * $row['quantity'];
   $totalDiscount += $row['discount'] * $row['quantity'];
   $totalAmount += $total;

  $image = $row['image'] ?: 'upload/no_image_icon_23500.jpg';
?>
<?php endforeach; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  try
  {
     
      if (

              !empty($_POST['name']) && 
              !empty($_POST['phone_number']) && 
              !empty($_POST['address']) && 
              !empty($_POST['city']) && 
              !empty($_POST['state']) && 
              !empty($_POST['country']) &&           
              !empty($_POST['pin_code'])&&           
              !empty($_POST['full_address']) ||
              empty($_POST['created_at']) ||
              empty($_POST['updated_at']) 
          )   
          {         
              $name = $_POST['name'];
              $phone_number = $_POST['phone_number'];
              $address = $_POST['address'];
              $city = $_POST['city'];
              $state = $_POST['state'];
              $country = $_POST['country'];
              $pin_code = $_POST['pin_code'];
              $full_address = $_POST['full_address'];

             
          
               $result=$onerecord->insertOrders($id,$name, $phone_number, $address,$city, $country, $state,$pin_code,$full_address,$customer_id,$totalAmount,$totalDiscount,$status);
                  if($result)
                  {
                    $onerecord->insertOrdersItems($id);
                    $onerecord->clearCart($user_id, $session_id);


                      header("Location:index.php");  
                      exit();
                  } else 
                  {
                      $error_message = " products not insert.";
                  }               
          }

      }

  catch (PDOException $e) {
      echo "error: " . $e->getMessage();
  }
}
?>

<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Checkout Form</title>
  </head>
  <style>
    .error {
        color: red;
    }
</style>
  <body class="bg-light">

<div class="container py-5">
    <h1 class="mb-5">Shipping Details</h1>
    <div class="row">
        <div class="col-8">
            <div class="card">
              <form action="" method="post" id="chkoutform">

              <div class="row">
                <div class="col-6 chk">
                  <label for="name">Contect Person Name </label>
                  <input type="text" class="form-control" name="name">
                </div>
                <div class="col-6 chk">
                  <label for="La\st name">Phone Number </label>
                  <input type="tel" class="form-control"  name="phone_number">
                </div>
              </div>

              <div class="row">
                <div class="col-8">
                  <label for="Address">Address</label>
                  <input type="text" class="form-control"  name="address">
                </div>
                <div class="col-4">
                  <label for="Address">City</label>
                  <input type="text" class="form-control"  aria-label="Address" name="city">
                </div>

              </div>
                  
          <div class="row">
             <div class="col-4">
              <label for="country">Country</label>
              <input type="text" class="form-control"  aria-label="First name" name="country">

            
            </div>
             <div class="col-4">
              <label for="state">State</label>
              <input type="text" class="form-control"  aria-label="First name" name="state">

             
            </div>
             <div class="col-4">
              <label for="zip">Pin Code</label>
              <input type="text" class="form-control" aria-label="zip" name="pin_code">
            </div>
            <div class="mb-4 chk">
            <label for="Address">Full Address</label>
            <input type="text" class="form-control" placeholder="1234 Main St" aria-label="Address" name="full_address">
          </div>
          </div>
        
          
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card cart-summary">
                <div class="card-body">
               
                    <h5 class="card-title mb-4">Order Summary</h5>
                    <div class="d-flex justify-content-between mb-2"><span>Subtotal</span><span><?php echo $totalProductPrice; ?></span></div>
                    <div class="d-flex justify-content-between mb-2"><span>Discount</span><span><?php echo $totalDiscount; ?></span></div>
                    <hr>
                   
                    <div class="d-flex justify-content-between mb-3"><strong>Total</strong><strong><?php echo $totalAmount; ?></strong></div>
                    <button type="submit" name="submit" id="submit" class="btn btn-primary w-100 mb-2">Place Order</button>

                  </form>
                    <a href="index.php" class="btn btn-outline-info w-100">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
</div>

    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/additional-methods.min.js"></script>

    <script>

$(document).ready(function () {

    $.validator.addMethod('filesize', function(value, element, param) 
    { return this.optional(element) || (element.files[0].size <= param) });
    
    $("#chkoutform").validate({
        rules: {
            
            name: {
                required: true,
            },
            phone_number: {
                required: true,
            },
            address: {
                required: true,
                
            },
            city: {
                required: true,
                // digits: true,
               
            },
            country: {
                required: true,
                // digits: true,
               
            },
            state: {
                required: true,
                // digits: true,
                
            },
            pin_code: {
                required: true,
                // digits: true,
                
            },
            full_address: {
                required: true,
                // digits: true,
                
            },
           
           
        },
        messages: {
           
            name: {
                required: "Please Enter Name"
            },
            phone_number: {
                required: "Please Enter Phone Number"
            },
            address: {
                required: "Please Enter an Address",
                
            },
            city: {
                required: "Please enter a City"
            },
            country: {
                required: "Please enter a country"
            },
          
            pin_code: {
                required: "Please enter a pin code"
            },  
            full_address: {
                required: "Please enter a full address"
            },
            
            
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        
        
    });
    
});
</script> 
</body>
</html>