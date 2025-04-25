<?php
session_start();

include_once('admin_function.php');
$admin = new Admin($conn); // create object Admin class

// if session not set then login page show
if(isset($_SESSION['name'])) {
    header("location:dashboard.php");
    exit();
}

$emailError = $passwordError = "";  

if(isset($_POST['submit'])) 
{ 
    $email=$_POST['email'];
    $password=$_POST['password'];
    $newPassword=md5($password);

    $row=$admin->checkLogin($email,$newPassword);  

    if($row)
    {
        $email=$row['email'];
        $password=$row['password'];

        $_SESSION['name']=$row['name'];
        $_SESSION['email']=$row['email'];

        header('location:dashboard.php');
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
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
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

<h1>Admin Panel Login </h1>
<p><?php echo $loginError; ?></p>

<form action="" method="post" id="login">
    <div class="input-form">
        <label for="email">Email:</label>
        <input type="email" name="email" id="" value="<?php echo $email; ?>">
        <?php
            if ($email_error != "") 
            {
                    echo "<p class='error_msg'>$email_error</p>"; 
            }
        ?>
    </div>

    <div class="input-form">
        <label for="password">Password:</label>
        <input type="password" name="password" id=""value="<?php echo $pdo_password; ?>">
    </div>
    <?php
        if ($password_error != "") 
        {
            echo "<p class='error_msg'>$password_error</p>"; 
        }
    ?>

    <br>
    <button type="submit" name="submit">Submit</button>
</form>

<script>
    $(document).ready(function(){
       
        $("#login").validate({
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
            
            // Error show after div
            errorPlacement: function(error, ele) {
                error.insertAfter(ele.parent(".input-form"));
            }
        });
    });
</script>

</body>
</html>
