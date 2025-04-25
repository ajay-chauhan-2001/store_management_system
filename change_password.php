<?php
session_start();
include "navbar.php";

// Redirect if not logged in
if (!isset($_SESSION['name'])) {
    header("location:signin.php");
    exit();
}

$emailError = $passwordError = $loginError = "";

if (isset($_POST['submit'])) {
     $oldPassword = md5($_POST['old_password']); // hashed for comparison
      $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        $loginError = "New password and confirm password do not match.";
    } else {
        // Assuming $onerecord is a DB class or object
      echo   $userId = $_SESSION['id'] ?? 0;
        
        // Fetch current user details (pseudo-code; you need to implement getUserById)
        $user = $onerecord->getUserById($userId);

        if ($user && $user['password'] === $oldPassword) {
            $hashedNewPassword = md5($newPassword);
            $update = $onerecord->updatePassword($userId, $hashedNewPassword); // write this method

            if ($update) {
                header('Location: index.php');
                exit();
            } else {
                $loginError = "Failed to update password. Try again.";
            }
        } else {
            $loginError = "Old password is incorrect.";
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>

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


<h1> Change Password </h1>
<p><?php echo $loginError; ?></p>

<form name="chngpwd" action="" method="post" onSubmit="return valid();">
<table align="center">
    
<div class="input-group">
        <label for="password">Old Password:</label>
        <input type="password" name="old_password" id="old_password">
        <span>*</span>
    </div>
    <div class="input-group">
        <label for="password">New Password:</label>
        <input type="password" name="new_password" id="new_password">
        <span>*</span>
    </div>
    <div class="input-group">
        <label for="password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" id="">
        <span id='message'></span>

        <span>*</span>
    </div>
    <br>
    <button type="submit" name="submit">Submit</button>
</table>
</form>
<p><a href="signup.php">Don't have an account? Sign up</a></p>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/additional-methods.min.js"></script>

<script type="text/javascript">
function valid()
{
if(document.chngpwd.old_password.value=="")
{
alert("Old Password Filed is Empty !!");
document.chngpwd.old_password.focus();
return false;
}
else if(document.chngpwd.new_password.value=="")
{
alert("New Password Filed is Empty !!");
document.chngpwd.new_password.focus();
return false;
}
else if(document.chngpwd.confirm_password.value=="")
{
alert("Confirm Password Filed is Empty !!");
document.chngpwd.confirm_password.focus();
return false;
}
else if(document.chngpwd.new_password.value!= document.chngpwd.confirm_password.value)
{
alert("Password and Confirm Password Field do not match  !!");
document.chngpwd.confirm_password.focus();
return false;
}
return true;
}

$('#new_password, #confirm_password').on('keyup', function () {
  if ($('#new_password').val() == $('#confirm_password').val()) {
    $('#message').html('Matching').css('color', 'green');
  } else 
    $('#message').html('Not Matching').css('color', 'red');
});
</script>
