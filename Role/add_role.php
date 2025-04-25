<?php
session_start();
include 'role_function.php';

if(!isset($_SESSION['name']))
{
    header("location:../login.php");
}
$admin = new Admin($conn);  // create object Admin class
$name = "";
$nameError="";

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
                empty($_POST['created_at']) ||
                empty($_POST['updated_at']) 
            )   
            {         
                $name = $_POST['name'];
              
                
                if($admin->insertCategory($name,$parent_id, $image))
                {
                    header("Location:role.php");  // redirect employee page
                    exit();

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
        <a href="role.php">Back Role</a>
    </button>
    <h1>Add Role</h1>
    <form action="" method="post" enctype="multipart/form-data" id="roleform">
        <div class="input-group">
            <label for="">Role Name</label>
            <input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>" >
            <span>*</span>
      
        <br>
        <button type="submit" name="submit">Submit</button>
    </form>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/additional-methods.min.js"></script>

 <script>

    $(document).ready(function () {

      
        $("#roleform").validate({
            rules: {
                
                name: {
                    required: true,
                },
                
               
            },
            messages: {
               
                name: {
                    required: "Please enter Role Name"
                },
                
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element.parent('.input-group'));
            },
            
            
        });
        
    });
</script> 