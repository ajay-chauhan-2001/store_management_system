<?php
session_start();
include 'product_function.php';

if(!isset($_SESSION['name']))
{
    header("location:../login.php");
}
$admin = new Admin($conn);  // create object Admin class
$name = $description = $price = $discount = $quantity = $category_id = $image = "";
$nameError = $descriptionError = $priceError = $discountError = $quantityError = $category_idError = $imageError="";

//   server side validation
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{

//   //  name error
   if (empty($_POST["name"])) {
        $nameError = " name is required";
    } else {
      $name = testInput($_POST["name"]);
     
      //preg_match  => return the match string founds
      
      if (!preg_match("/^[a-zA-Z-' ]*$/",$name))   
      {    
        $nameError = "Only letters and white space allowed";  
      }
    }

    // last name error
    if (empty($_POST["description"])) {
        $descriptionError = "description is required";
    }
    //  else {
    //   $description = testInput($_POST["description"]);
      
    //   if (!preg_match("/^[a-zA-Z-' ]*$/",$description)) {
    //     $descriptionError = "Only letters and white space allowed";
    //   }
    // }

    // email error
    if (empty($_POST["price"])) {
      $priceError = "plz enter price";
    } else {
        $discount = testInput($_POST["discount"]);
        
        if (!preg_match("/^\d{10}$/", $discount)) //\d digit
         {       
            $discountError = "Only numeric values are allowed!!";
        }
        
    }
    
    // phone number error
    if (empty($_POST["discount"])) {
        $discountError = "enter the discount required";
    } else {
        $discount = testInput($_POST["discount"]);
        
        if (!preg_match("/^\d{10}$/", $discount)) //\d digit
         {       
            $discountError = "Only numeric values are allowed!!";
        }
        
    }
    if (empty($_POST["quantity"])) {
        $quantityError = "enter the quantity required";
    } else {
        $quantity = testInput($_POST["quantity"]);
        
        if (!preg_match("/^\d{10}$/", $quantity)) //\d digit
         {       
            $quantityError = "Only numeric values are allowed!!";
        }
        
    }
    
    // company name error
    if (empty($_POST["category_id"])) {
        $category_idError = "Please Select Any category  ";
    }
    
// status error
    if (empty($_POST["status"])) {
      $statusError = "Please Select Any Status";
    } else {
      $status = testInput($_POST["status"]);
    }

    if (empty($_POST["image"])) {
        $imageError = "Please upload the image";
      } else {
        $image = testInput($_POST["image"]);
      }
   
    }
  
  function testInput($data) {
    $data = trim($data);  // remove whtespace
    $data = stripslashes($data);// removes backslashes(\) added 
    $data = htmlspecialchars($data); // convert to speacial char into html code ex. < with &lt; and > with &gt;
    return $data;
  }
    try
    {
       
        if (
                // check input is empty or not
                !empty($_POST['name']) && 
                !empty($_POST['description']) && 
                !empty($_POST['price']) && 
                !empty($_POST['discount']) && 
                !empty($_POST['quantity']) &&           
                !empty($_POST['category_id'])&&           
                !empty($_POST['image']) ||
                empty($_POST['created_at']) ||
                empty($_POST['updated_at']) 
            )   
            {         
                $name = $_POST['name'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $discount = $_POST['discount'];
                $quantity = $_POST['quantity'];
                $category_id = $_POST['category_id'];
                $image = $_FILES['image']['name'];
            
                //  image upload             
                $targetDir = "upload/";
                    if (!is_dir($targetDir)) 
                    {
                      
                        mkdir($targetDir);  // if not there create folder
                        chmod($targetDir, 0777); //file permission
                    } 
                    chmod($targetDir, 0777);
                        
                        $ext = ".".pathinfo($image, PATHINFO_EXTENSION); // get image extension
                        $strtotime = time();
                        $filename = "product_".$strtotime.$ext;
                        $image = $targetDir .basename($filename);
                        
                        move_uploaded_file($_FILES['image']['tmp_name'],$image);
                        chmod($image, 0777); //image permission
                       
                
                    if ($admin->insertProduct($name, $description, $price,$discount, $quantity, $category_id,$image)) 
                    {
                        header("Location:products.php");  // redirect employee page
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


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    span,p,.error {
        color: red;
    }
</style>
<body>
    <button>
        <a href="products.php">Back Product</a>
    </button>
    <h1>Add Products</h1>
    <form action="" method="post" enctype="multipart/form-data" id="productid">
        <div class="input-group">
            <label for="">Product Name</label>
            <input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>" >
            <span>*</span>
            <p><?php echo $nameError; ?></p>    <!-- first name error show -->

        </div>
       
        <div class="input-group">
            <label for="">description</label>
            <textarea name="description" id="" value="<?php echo isset($description) ? $description : ''; ?>"></textarea>
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
            <label for="">discount</label>
            <input type="number" name="discount" value="<?php echo isset($discount) ? $discount : ''; ?>" >
            <span>*</span>
            <p><?php echo $descriptionError; ?></p>  
           
        </div>
        <div class="input-group">
            <label for="">quantity</label>
            <input type="tel" name="quantity"  value="<?php echo isset($quantity) ? $quantity : ''; ?>" >
            <span>*</span>
            <p><?php echo $quantityError; ?></p>  
        </div>
        <div class="input-group">
            <label for="">Category</label>
            <select name="category_id">
                <option value="">Select category</option>
                <?php
                try 
                {
                    $sql = "SELECT id, name FROM categories";
                    $stmt = $conn->query($sql);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $selected = isset($category_id) && $category_id == $row['id'] ? 'selected' : '';
                        echo "<option value='{$row['id']}' {$selected}>{$row['name']}</option>";
                    }
                } catch (PDOException $e) {
                    echo "Error fetching companies: " . $e->getMessage();
                }
                ?>
            </select> 
            <span>*</span>
            <p><?php echo $category_idError; ?></p> <!-- show company error -->
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
        
        $("").validate({
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
                    required: true,
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
                    required: "Please enter Product  Name"
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