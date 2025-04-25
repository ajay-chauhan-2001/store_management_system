<?php
session_start(); // session start
session_unset(); // varible delete
session_destroy(); //  delete record
header("location:signin.php");// redirect page