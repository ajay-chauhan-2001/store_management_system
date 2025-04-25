<?php
session_start();
include "product_function.php";

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
$description = $row['description'];
$price = $row['price'];
$discount = $row['discount'];
$quantity = $row['quantity'];
$category_id = $row['category_id'];
$oldimage = $row['image'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $quantity = $_POST['quantity'];
    $category_id = $_POST['category_id'];
    $image = $oldimage;  
   
    if ($_FILES['image']['name']) {
     
        $targetDir = "upload/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777);
        }
        
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $timestamp = time();
        $filename = "product_" . $timestamp . "." . $ext;
        $image = $targetDir . basename($filename);
        
 
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image)) {
            chmod($image, 0777); 
        } else {
            $imageError = "Failed to upload image.";
        }
    }
    
    try {
        $updateSql = $admin->updateProduct($id, $name, $description, $price, $discount, $quantity, $category_id, $image);
        
        if ($updateSql) {
            header("Location: products.php");  
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
    <button><a href="products.php">Back to Products</a></button>
    <h1>Edit Product</h1>
    <form action="" method="post" enctype="multipart/form-data" id="productid">
        <div class="input-group">
            <label for="name">Product Name</label>
            <input type="text" name="name" value="<?php echo $name; ?>">
            <span>*</span>
        </div>
        
        <div class="input-group">
            <label for="description">Description</label>
            <textarea name="description"><?php echo $description; ?></textarea>
            <span>*</span>
        </div>
        
        <div class="input-group">
            <label for="price">Price</label>
            <input type="number" name="price" value="<?php echo $price; ?>">
            <span>*</span>
        </div>
        
        <div class="input-group">
            <label for="discount">Discount</label>
            <input type="number" name="discount" value="<?php echo $discount; ?>">
            <span>*</span>
        </div>
        
        <div class="input-group">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" value="<?php echo $quantity; ?>">
            <span>*</span>
        </div>
        
        <div class="input-group">
            <label for="category_id">Category</label>
            <select name="category_id">
                <option value="">Select category</option>
                <?php
                try {
                    $sql = "SELECT id, name FROM categories";
                    $stmt = $conn->query($sql);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($category_id == $row['id']) ? 'selected' : '';
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
            <img src="<?php echo $oldimage ?: 'upload/no_image_icon_23500.jpg'; ?>" width="80px" height="80px">
            <input type="file" name="image">
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
