<?php
session_start();
include 'product_function.php';

if (!isset($_SESSION['name'])) {
    header("location:../login.php");
}
$admin = new Admin($conn);  // create object Admin class
$name = $description = $price = $discount = $quantity = $category_id = $image = "";
$nameError = $descriptionError = $priceError = $discountError = $quantityError = $category_idError = $imageError = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //  product name
    if (empty($_POST["name"])) {
        $nameError = "Name is required";
    } else {
        $name = testInput($_POST["name"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameError = "Only letters and white space allowed";
        }
    }

    //  description
    if (empty($_POST["description"])) {
        $descriptionError = "Description is required";
    } else {
        $description = testInput($_POST["description"]);
    }

    // Validate price
    if (empty($_POST["price"])) {
        $priceError = "Price is required";
    } else {
        $price = testInput($_POST["price"]);
        if (!is_numeric($price) || $price <= 0) {
            $priceError = "Please enter a valid price greater than 0";
        }
    }

    // Validate discount
    if (empty($_POST["discount"])) {
        $discountError = "Discount is required";
    } else {
        $discount = testInput($_POST["discount"]);
        if (!is_numeric($discount) || $discount < 0) {
            $discountError = "Please enter a valid discount (non-negative)";
        }
    }

    // Validate quantity
    if (empty($_POST["quantity"])) {
        $quantityError = "Quantity is required";
    } else {
        $quantity = testInput($_POST["quantity"]);
        if (!is_numeric($quantity) || $quantity <= 0) {
            $quantityError = "Please enter a valid quantity greater than 0";
        }
    }

    // Validate category_id
    if (empty($_POST["category_id"])) {
        $category_idError = "Please select a category";
    } else {
        $category_id = testInput($_POST["category_id"]);
    }

    // Validate image upload
    if (empty($_FILES["image"]["name"])) {
        $imageError = "Please upload an image";
    } else {
        $image = $_FILES["image"]["name"];
    }

    // If no  errors
    if (empty($nameError) && empty($descriptionError) && empty($priceError) && empty($discountError) && empty($quantityError) && empty($category_idError) && empty($imageError)) {
        try {
            $targetDir = "upload/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777); // if not there, create folder
                chmod($targetDir, 0777); // file permission
            }

            $ext = "." . pathinfo($image, PATHINFO_EXTENSION); // get image extension
            $strtotime = time();
            $filename = "product_" . $strtotime . $ext;
            $image = $targetDir . basename($filename);

         
            move_uploaded_file($_FILES['image']['tmp_name'], $image);
            chmod($image, 0777); // image permission

            // Insert the product 
            if ($admin->insertProduct($name, $description, $price, $discount, $quantity, $category_id, $image)) {
                header("Location: products.php"); 
                exit();
            } else {
                $error_message = "Products not inserted.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

function testInput($data)
{
    $data = trim($data);  // remove whitespace
    $data = stripslashes($data); // removes backslashes (\)
    $data = htmlspecialchars($data); // convert to special chars into HTML code (e.g. < with &lt; and > with &gt;)
    return $data;
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
    <button>
        <a href="products.php">Back to Products</a>
    </button>
    <h1>Add Product</h1>
    <form action="" method="post" enctype="multipart/form-data" id="productid">
        <div class="input-group">
            <label for="">Product Name</label>
            <input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>" >
            <span>*</span>
            <p><?php echo $nameError; ?></p>
        </div>
       
        <div class="input-group">
            <label for="">Description</label>
            <textarea name="description"><?php echo isset($description) ? $description : ''; ?></textarea>
            <span>*</span>
            <p><?php echo $descriptionError; ?></p>  
        </div>
        <div class="input-group">
            <label for="">Price</label>
            <input type="number" name="price" value="<?php echo isset($price) ? $price : ''; ?>" >
            <span>*</span>
            <p><?php echo $priceError; ?></p>  
        </div>
        <div class="input-group">
            <label for="">Discount</label>
            <input type="number" name="discount" value="<?php echo isset($discount) ? $discount : ''; ?>" >
            <span>*</span>
            <p><?php echo $discountError; ?></p>  
        </div>
        <div class="input-group">
            <label for="">Quantity</label>
            <input type="tel" name="quantity" value="<?php echo isset($quantity) ? $quantity : ''; ?>" >
            <span>*</span>
            <p><?php echo $quantityError; ?></p>  
        </div>
        <div class="input-group">
            <label for="">Category</label>
            <select name="category_id">
                <option value="">Select Category</option>
                <?php
                    $sql = "SELECT id, name FROM categories WHERE parent_id IS NULL";
                    $stmt = $conn->query($sql);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                <?php } ?>
            </select> 
            <span>*</span>
            <p><?php echo $category_idError; ?></p>
        </div>
        
        <div class="input-group">
            <label for="">Image</label>
            <input type="file" name="image" id="">
            <span>*</span>
            <p><?php echo $imageError; ?></p>  
        </div>
        <br>
        <button type="submit" name="submit">Submit</button>
    </form>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/additional-methods.min.js"></script>

 <script>

    $(document).ready(function () {

        $.validator.addMethod('filesize', function(value, element, param) 
        { return this.optional(element) || (element.files[0].size <= param) });
        
        $("#productid").validate({
            rules: {
                
                name: {
                    required: true,
                },
                category_id: {
                    required: true,
                },
                description: {
                    required: true,
                    
                },
                price: {
                    required: true,
                    digits: true,
                   
                },
                discount: {
                    required:true,
                    digits: true,
                   
                },
                quantity: {
                    required: true,
                    digits: true,
                    
                },
                image: {
                    required: true,
                    filesize: 2097152,

                },
               
            },
            messages: {
               
                name: {
                    required: "Please enter Product Name"
                },
                category_id: {
                    required: "Please Select Category"
                },
                description: {
                    required: "Please enter an description",
                    
                },
                price: {
                    required: "Please enter a Price"
                },
                discount: {
                    required: "Please enter a discount"
                },
                quantity: {
                    required: "Please enter a quantity"
                },
                image: {
                    required: "Please upload image",
                    filesize: "Please image size is less then 2 mb uplaod"
                },
                
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element.parent('.input-group'));
            },
            
            
        });

        
    });
</script> 
