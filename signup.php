<?php
session_start();
include "navbar.php";

$userNme = $name= $email = $password = $address= $phoneNumber=$roleId = $image = "";
$userNameError = $nameError = $emailError = $passwordError = $addressError = $phoneNumberError=$role_idError = $imageError = "";


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
                !empty($_POST['username']) && 
                !empty($_POST['password']) &&    
                // !empty($_POST['role_id']) &&   
                !empty($_POST['name']) &&  
                !empty($_POST['email']) &&           
                !empty($_POST['phone_number'])&&   
                !empty($_POST['address'])&&   
                !empty($_POST['image']) ||
                empty($_POST['created_at']) ||
                empty($_POST['updated_at']) 
            )   
            {         
             echo    $userName = $_POST['username'];
             echo    $password = $_POST['password'];
                $newPassword=md5($password);
                // $roleId = $_POST['role_id'];
                $name = $_POST['name'];
                $email = $_POST['email'];
                $phoneNumber = $_POST['phone_number'];
                $address = $_POST['address'];
                $image = $_FILES['image']['name'];
                
            //  die();
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
                        $filename = "customer_".$strtotime.$ext;
                        $image = $targetDir .basename($filename);
                        
                        move_uploaded_file($_FILES['image']['tmp_name'],$image);
                        chmod($image, 0777); //image permission
                       
                       if($emailError=$onerecord->checkEmail($email))
                       {
                            $emailError= " Email already exists!";
                       }
                       else
                       {
                          $onerecord->insertUser($userName,$newPassword, $roleId,$name, $email, $phoneNumber,$address ,$image);                      
                        //   die(); 
                          header("Location:signin.php"); 
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
    <title>Signup</title>

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>
<style>
    span,p,.error {
        color: red;
    }
</style>
<body>

    <h1>Create New Account</h1>
    <p> <?php echo $emailError; ?></p>
    <form action="" method="post" enctype="multipart/form-data" id="userform">
        <div class="input-group">
            <label for="">User Name</label>
            <input type="text" name="username" value="<?php echo isset($userName) ? $userName : ''; ?>" >
            <span>*</span>
            <p><?php echo $nameError; ?></p>
        </div>
        <div class="input-group">
            <label for=""> Name</label>
            <input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>" >
            <span>*</span>
            <p><?php echo $nameError; ?></p>
        </div>
        <div class="input-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="" value="<?php echo $email? $email : ''; ?>">
        <span>*</span>
       
    </div>

    <div class="input-group">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password"value="<?php echo $password? $password : ''; ?>">
        <span>*</span>
    </div>
    <div class="input-group">
        <label for="password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" id=""value="<?php echo $password? $password : ''; ?>">
        <span id='message'></span>

        <span>*</span>
    </div>
       
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
            <label for="">Image</label>
            <input type="file" name="image" id="">
            <span>*</span>
            <p><?php echo $imageError; ?></p>  
        </div>
        <br>
        <button type="submit" name="submit">Submit</button>
    
    <p><a href="signin.php">Already have an account? Sign In </a></p>
    
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
                    digits: true,
                    maxlength: 10
                },
                address: {
                    required: true,
                },
               
                image: {
                    required: true,
                    filesize: 2097152,
                },               
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
              
                address: {
                    required: "Please enter an Address",
                    
                },
                phone_number: {
                    required: "Please enter a Phone Number",
                    rangelength:'Phone Number should be 10 digit number.'

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

        $('#password, #confirm_password').on('keyup', function () {
  if ($('#password').val() == $('#confirm_password').val()) {
    $('#message').html('Matching').css('color', 'green');
  } else 
    $('#message').html('Not Matching').css('color', 'red');
});

        
    });
</script> 
