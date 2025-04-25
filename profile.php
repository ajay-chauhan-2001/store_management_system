<?php
session_start();

include "navbar.php";

if(!isset($_SESSION['name']))
{
    header("location:signin.php");
}

 $user_id = $_SESSION['all']['id'] ?? 0;
$row=$onerecord->getUserById($user_id,$session_id);
// echo "<pre>";
// print_r($row);
 $userName=$row['username'];
 $name=$row['name'];
 $email=$row['email'];
 $phoneNumber=$row['phone_number'];
 $address=$row['address'];
 $oldImage=$row['image'];

// $updateUser=$onerecord->updateUserEditableFields($id, $name, $address, $phoneNumber, $image);
if($updateUser)
{
header("Location:index.php");  
// exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>
<style>
    body{margin-top:0px;
background-color:#f2f6fc;
color:#69707a;
}
.img-account-profile {
    height: 10rem;
}
.rounded-circle {
    border-radius: 50% !important;
}
.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
}
.card .card-header {
    font-weight: 500;
}
.card-header:first-child {
    border-radius: 0.35rem 0.35rem 0 0;
}
.card-header {
    padding: 1rem 1.35rem;
    margin-bottom: 0;
    background-color: rgba(33, 40, 50, 0.03);
    border-bottom: 1px solid rgba(33, 40, 50, 0.125);
}
.form-control, .dataTable-input {
    display: block;
    width: 100%;
    padding: 0.875rem 1.125rem;
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1;
    color: #69707a;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #c5ccd6;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.35rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.nav-borders .nav-link.active {
    color: #0061f2;
    border-bottom-color: #0061f2;
}
.nav-borders .nav-link {
    color: #69707a;
    border-bottom-width: 0.125rem;
    border-bottom-style: solid;
    border-bottom-color: transparent;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    padding-left: 0;
    padding-right: 0;
    margin-left: 1rem;
    margin-right: 1rem;
}
</style>
<body>
    <div class="container-xl px-4 mt-4">
    <button>
    <a href="index.php">Back</a>
    </button>
  
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>

                <div class="mb-3">
        <img class="img-account-profile rounded-circle mb-2" src="Customer/<?php echo $row['image'] ? $row['image'] : 'upload/no_image_icon_23500.jpg'; ?>" width="80" height="80"><br>
        <input type="file" name="profile_image" class="form-control mt-2">
        <button class="btn btn-primary" type="file">Upload new image</button>
    
    </div>

            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
    <div class="row gx-3 mb-3">
        <!-- User Name (read-only) -->
        <div class="col-md-6">
            <label class="small mb-1" for="inputUsername">Username</label>
            <input class="form-control" id="inputUsername" type="text" name="username" value="<?php echo $row['username']; ?>" readonly>
        </div>

        <!-- Name (editable) -->
        <div class="col-md-6">
            <label class="small mb-1" for="inputName">Name</label>
            <input class="form-control" id="inputName" type="text" name="name" value="<?php echo $row['name']; ?>">
        </div>
    </div>

    <div class="row gx-3 mb-3">
        <!-- Email (read-only) -->
        <div class="col-md-6">
            <label class="small mb-1" for="inputEmail">Email</label>
            <input class="form-control" id="inputEmail" type="email" name="email" value="<?php echo $row['email']; ?>" readonly>
        </div>

        <!-- Phone number (editable) -->
        <div class="col-md-6">
            <label class="small mb-1" for="inputPhone">Phone Number</label>
            <input class="form-control" id="inputPhone" type="tel" name="phone_number" value="<?php echo $row['phone_number']; ?>">
        </div>
    </div>

    <div class="row gx-3 mb-3">
        <!-- Address (editable) -->
        <div class="col-md-12">
            <label class="small mb-1" for="inputAddress">Address</label>
            <input class="form-control" id="inputAddress" type="text" name="address" value="<?php echo $row['address']; ?>">
        </div>
    </div>

    <!-- Profile Image Upload -->
    

    <!-- Submit Button -->
    <button class="btn btn-primary" type="submit" name="update">Save Changes</button>
</form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>