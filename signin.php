<?php
session_start();
include "navbar.php";
// include('user_function.php');
// $admin = new User($conn); // create object Admin class

// if session not set then login page show
if(isset($_SESSION['name'])) 
{
    header("location:index.php");
    exit();
}
// echo "hello";
$emailError = $passwordError = "";  

if(isset($_POST['submit'])) 
{ 

     $email=$_POST['email'];
     $password=$_POST['password'];
    $newPassword=md5($password);
     $row=$onerecord->checkLogin($email,$newPassword);  

    $_SESSION['all']=$row;

    if($row)

    {
        
        $email=$row['email'];
        $password=$row['password'];

        $_SESSION['username']=$row['username'];
        $_SESSION['name']=$row['name'];
        $_SESSION['phone_number']=$row['phone_number'];
        $_SESSION['address']=$row['address'];
        $_SESSION['image']=$row['image'];
        $_SESSION['email']=$row['email'];
        $_SESSION['role_id']=$row['role_id'];
        $_SESSION['id']=$row['id'];
        $_SESSION['user_id']=$row['user_id'];




        header('location:index.php');
    }
    else
    {
        $loginError="Invalid email or password";
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <style>
        /* error message */
        label.error {
            color: red;
        }
        .error_msg,p {
            color: red;
        }
    </style>
</head>
<body>


<h1> Login </h1>
<p><?php echo $loginError; ?></p>

<form action="" method="post" id="loginform">
    <div class="input-form">
        <label for="email">Email:</label>
        <input type="email" name="email" id="" value="<?php echo $email; ?>">
        
    </div>

    <div class="input-form">
        <label for="password">Password:</label>
        <input type="password" name="password" id=""value="<?php echo $pdo_password; ?>">
    </div>
    <br>
    <button type="submit" name="submit">Submit</button>
    
</form>
<p><a href="signup.php">Don't have an account? Sign up</a></p>


</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/additional-methods.min.js"></script>

<script>
    $(document).ready(function(){
       
        $("#loginform").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                }
            },
            messages: {
                email: {
                    required: "Please enter your email.",
                    email: "Please enter a valid email address."
                },
                password: {
                    required: "Please enter your password."
                }
            },

            submitHandler: function(form) {
                form.submit();
            },

            // Error show after div
            errorPlacement: function(error, ele) {
                error.insertAfter(ele.parent(".input-form"));
            }
        });
    });
</script>


