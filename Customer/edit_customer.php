<?php
session_start();
include "customer_function.php";

if(!isset($_SESSION['name'])) {
    header("location:../login.php");
}
$admin = new Admin($conn);  // create object Admin class

// Initialize variables for form data
$name = $description = $price = $discount = $quantity = $category_id = $image = "";
$nameError = $descriptionError = $priceError = $discountError = $quantityError = $category_idError = $imageError = "";

// Get the product id from the URL
$id = $_GET['id'];
$onerecord = new Admin($conn);
$row = $onerecord->fetchOneProduct($id);

// Populate the form fields with existing product data
$userName = $row['username'];
$name = $row['name'];
$email = $row['email'];
$address = $row['address'];
$phoneNumber = $row['phone_number'];
$role_id = $row['role_id'];
$oldimage = $row['image'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phoneNumber = $_POST['phone_number'];
    $role_id = $_POST['role_id'];
    $image = $oldimage;  
   
    if ($_FILES['image']['name']) {
     
        $targetDir = "upload/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777);
        }
        
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $timestamp = time();
        $filename = "customer_" . $timestamp . "." . $ext;
        $image = $targetDir . basename($filename);
        
 
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image)) {
            chmod($image, 0777); 
        } else {
            $imageError = "Failed to upload image.";
        }
    }
    
    try {
        $updateSql = $admin->updateCustomer($id,$userName,$name,$email,$address,$phoneNumber,$role_id,$image);
        
        if ($updateSql) {
            header("Location: customers.php");  
            exit();
        } else {
            $errorMessage = "customer not updated.";
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
    <title>Add Product</title>
</head>
<style>
    span,p,.error {
        color: red;
    }
</style>
<body>
    <!-- <button>
        <a href="products.php">Back to Products</a>
    </button> -->
    <h1>Edit Customer</h1>
    <form action="" method="post" enctype="multipart/form-data" id="userform">
        <div class="input-group">
            <label for="">User Name</label>
            <input type="text" name="username" value="<?php echo $userName; ?>" >
            <span>*</span>
            <p><?php echo $nameError; ?></p>
        </div>
        <div class="input-group">
            <label for=""> Name</label>
            <input type="text" name="name" value="<?php echo  $name ; ?>" >
            <span>*</span>
            <p><?php echo $nameError; ?></p>
        </div>
        <div class="input-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="" value="<?php echo $email? $email : ''; ?>" readonly>
        
    </div>

    <!-- <div class="input-group">
        <label for="password">Password:</label>
        <input type="password" name="password" id="">
    </div> -->
       
        <div class="input-group">
            <label for="">Address</label>
            <textarea name="address"><?php echo isset($address) ? $address : ''; ?></textarea>
            <span>*</span>
            <p><?php echo $addressError; ?></p>  
        </div>
        <div class="input-group">
            <label for="">Phone Number</label>
            <input type="number" name="phone_number" maxlength="10" value="<?php echo isset($phoneNumber) ? $phoneNumber : ''; ?>" >
            <span>*</span>
            <p><?php echo $phoneError; ?></p>  
        </div>

        <div class="input-group">
            <label for="role_id">Category</label>
            <select name="role_id">
                <option value="">Select category</option>
                <?php
                try {
                    $sql = "SELECT id, name FROM roles";
                    $stmt = $conn->query($sql);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($role_id == $row['id']) ? 'selected' : '';
                        echo "<option value='{$row['id']}' {$selected}>{$row['name']}</option>";
                    }
                } catch (PDOException $e) {
                    echo "Error fetching categories: " . $e->getMessage();
                }
                ?>
            </select> 
            <span>*</span>
        </div>
       
        <div class="input-group">
            <label for="image">Image</label>
            <img src="upload/<?php echo $oldimage ?: 'upload/no_image_icon_23500.jpg'; ?>" width="80px" height="80px" readonly>
            <input type="file" name="image" readonly>
        </div>
        <br>
        <button type="submit" name="submit">Submit</button>
    
   
    
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/additional-methods.min.js"></script>

 <script>

    $(document).ready(function () {

        $.validator.addMethod('filesize', function(value, element, param) 
        { return this.optional(element) || (element.files[0].size <= param) });
        
        $("#userform").validate({
            rules: {
                username: {
                    required: true,
                },
                name: {
                    required: true,
                    
                },
                email: {
                    required: true,
                    email:true,
                },
                password: {
                    required: true,
                    
                },
                phone_number: {
                    required: true,
                    // rangelength: [10, 12],
                    digits: true,
                    maxlength: 10
                },
                address: {
                    required: true,
                },
                role_id: {
                    required: true,
                },
              
                // image: {
                //     required: true,
                //     filesize: 2097152,
                // },               
            },
            messages: {
                username: {
                    required: "Please enter User Name"
                },
                name: {
                    required: "Please enter Your Name"
                },
                email: {
                    required: "Please enter an Email",
                    email: "Please Enter Valid Email format"
                },
                password: {
                    required: "Please enter Password"
                },
                role_id: {
                    required: "Please Select Role"
                },
                address: {
                    required: "Please enter an Address",
                    
                },
                phone_number: {
                    required: "Please enter a Phone Number",
                    rangelength:'Phone Number should be 10 digit number.'

                },
               
                // image: {
                //     required: "Please upload image",
                //     filesize: "Please image size is less then 2 mb uplaod"
                // },
                
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element.parent('.input-group'));
            },
            
            
        });

        
    });
</script> 
