<?php
session_start();
include 'category_function.php';

if(!isset($_SESSION['name']))
{
    header("location:../login.php");
}
$admin = new Admin($conn);  // create object Admin class
$name = $parent_id = $image = "";
$nameError = $parent_idError = $imageError = $checkCategory="";

//   server side validation
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{

    // if (empty($_POST["name"])) {
    //     $nameError = " name is required";
    // } 
    // else {
    //   $name = testInput($_POST["name"]);
     
    //   //preg_match  => return the match string founds
      
    //   if (!preg_match("/^[a-zA-Z-' ]*$/",$name))   
    //   {    
    //     $nameError = "Only letters and white space allowed";  
    //   }
    // }


    // // company name error
    // // if (empty($_POST["parent_id"])) {
    // //     $parent_idError = "Please Select Any category  ";
    // // }
    

    // if (empty($_POST["image"])) {
    //     $imageError = "Please Select Any Image";
    //   } else {
    //     $image = testInput($_POST["image"]);
    //   }
  
//   function testInput($data) {
//     $data = trim($data);  // remove whtespace
//     $data = stripslashes($data);// removes backslashes(\) added 
//     $data = htmlspecialchars($data); // convert to speacial char into html code ex. < with &lt; and > with &gt;
//     return $data;
//   }
    try
    {
       
        if (
                // check input is empty or not
                !empty($_POST['name']) &&         
                !empty($_POST['parent_id'])||         
                !empty($_POST['image']) ||
                empty($_POST['created_at']) ||
                empty($_POST['updated_at']) 
            )   
            {         
                $name = $_POST['name'];
                 $parent_id = $_POST['parent_id'] ?? null ;
                $image = $_FILES['image']['name'];
                
            //    $row=$admin->checkCategory($name);
             
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
                        $filename = "category_".$strtotime.$ext;
                        $image = $targetDir .basename($filename);
                        
                        move_uploaded_file($_FILES['image']['tmp_name'],$image);
                        chmod($image, 0777); //image permission
                       
                
                    if ($admin->insertCategory($name,$parent_id, $image)) 
                    {
                        header("Location:category.php");  // redirect employee page
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
        <a href="category.php">Back Category</a>
    </button>
    <h1>Add Category</h1>
    <p><?php echo $checkCategory; ?></p>
    <form action="" method="post" enctype="multipart/form-data" id="productid">
        <div class="input-group">
            <label for="">Category Name</label>
            <input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>" >
            <span>*</span>
        </div>      
        <div class="input-group">
            <label for="">Parent</label>
            <select name="parent_id">
                <option value="">Select category</option>
                <?php
               
                    $sql = "SELECT id, name FROM categories where parent_id IS NULL";
                    $stmt = $conn->query($sql);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
                    { 
                        ?>
                    <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                    <?php } ?>
  
            </select> 
            <span>*</span>
            <p><?php echo $company_error; ?></p> <!-- show company error -->
        </div>
        
        <div class="input-group">
            <label for="">Image</label>
           <input type="file" name="image" id="">
            <span>*</span>
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
                
                image: {
                    required: true,
                    filesize: 2097152,

                },
               
            },
            messages: {
               
                name: {
                    required: "Please enter Category Name"
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

