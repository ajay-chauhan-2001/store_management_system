<?php
session_start();
include "role_function.php";

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
$name = $row['name'];
$category_id = $row['parent_id'];
$oldimage = $row['image'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
  
    $category_id = $_POST['parent_id'];
    $image = $oldimage;  
   
    if ($_FILES['image']['name']) {
     
        $targetDir = "upload/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777);
        }
        
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $timestamp = time();
        $filename = "category_" . $timestamp . "." . $ext;
        $image = $targetDir . basename($filename);
        
 
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image)) {
            chmod($image, 0777); 
        } else {
            $imageError = "Failed to upload image.";
        }
    }
    
    try {
        $updateSql = $admin->updatecategory($id, $name,$parent_id, $image);
        
        if ($updateSql) {
            header("Location:role.php");  
            exit();
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
    <title>Edit Product</title>
</head>
<style>
    span, p, .error {
        color: red;
    }
</style>
<body>
    <button><a href="role.php">Back to Role</a></button>
    <h1>Edit Role</h1>
    <form action="" method="post" enctype="multipart/form-data" id="productid">
        <div class="input-group">
            <label for="name">Role Name</label>
            <input type="text" name="name" value="<?php echo $name; ?>">
            <span>*</span>
        </div>
        <button type="submit" name="submit">Submit</button>
    </form>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/additional-methods.min.js"></script>

<!-- <script>
    $(document).ready(function () {
        $("#productid").validate({
            rules: {
                name: { 
                    required: true 
                },
                category_id: 
                { required: true 

                },
                description: 
                { required: true 

                },
                price: 
                { 
                    required: true, digits: true 
                },
                discount: 
                { 
                    required: true, digits: true 

                },
                quantity: { required: true, digits: true },
                image: { required: true, filesize: 2097152 }
            },
            messages: {
                name: "Please enter Product Name",
                category_id: "Please select a Category",
                description: "Please enter a description",
                price: "Please enter a valid Price",
                discount: "Please enter a valid Discount",
                quantity: "Please enter a valid Quantity",
                image: 
                { 
                    required: "Please upload an image", filesize: "Image size must be less than 2 MB" }
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element.parent('.input-group'));
            }
        });
    });
</script> -->
</html>
