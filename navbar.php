<?php
session_start();
include('user_function.php');
$onerecord = new User($conn);


  $user_id= $_SESSION['all']['id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>                                                                                                                                                                                                                                                                                                                      
<div class="main-navbar shadow-sm sticky-top">
    <div class="top-navbar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2 my-auto d-none d-sm-none d-md-block d-lg-block">
                    <h5 class="brand-name">Store Management System</h5>
                </div>
                <div class="col-md-5 my-auto"></div>
                <div class="col-md-5 my-auto">
                    <ul class="nav justify-content-end">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">All Categories</a>
                        </li>

                        
                                             
                        <li class="nav-item">
                            
                            <a class="nav-link" href="cart.php">
                                <i class="fa fa-shopping-cart"></i>
                                 Cart
                                <span class=" bg-danger" id="cart-count">
                                    <?php
                                   
                                       $total=$onerecord->fetchAllCartRecord($id,$user_id,$session_id);
                                        $number=count($total);
                                        if($number > 0)
                                        {
                                        echo $number;

                                        }
                                       
                                ?>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <?php if (isset($_SESSION['name'])): ?>
                                
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo $_SESSION['name']; ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="profile.php"><i class="fa fa-user"></i> Profile</a></li>
                                    <li><a class="dropdown-item" href="orders.php"><i class="fa fa-list"></i> My Orders</a></li>
                                    <li><a class="dropdown-item" href="change_password.php"><i class="fa fa-key" aria-hidden="true"></i>
                                    Change Password</a></li>
                                    <li><a class="dropdown-item" href="customer_logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>

                                </ul>
                            <?php else: ?>
                                <li><a class="nav-link" href="signin.php"><i class="fa fa-sign-in"></i> Signin</a></li>
                                <li><a class="nav-link" href="signup.php"><i class="fa fa-sign-up"></i> Signup</a></li>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
