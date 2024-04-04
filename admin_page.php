<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login.php');
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>User  Page</title>
      <link rel="stylesheet" href="css/style3.css">
      <link rel="stylesheet" href="css/style.css">
      <link rel="shortcut icon" type="x-icon" href="AppFavicon.png">
      <link rel="stylesheet" href="css/font-awesome-4.7.0/">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
      
   </head>
   
   <body style="background: url(LogInImage.jpg);background-repeat: no-repeat;background-size: 100%;">
   <div class="wrapper">
         <input type="checkbox" id="btn" hidden>
         <label for="btn" class="menu-btn">
         <i class="fas fa-bars"></i>
         <i class="fas fa-times"></i>
         </label>
         <nav id="sidebar">
            <div class="title">
            <h3> <a href="user_page.php" style="color: black;">Ifrane<span style="color: brown;">Warehouse</span></a></h3>
            </div>
            <ul class="list-items">
               <li><a href="admin_page.php"><i class="fas fa-home"></i>Home</a></li>
               <li><a href="UserManagement.php"><i class="fas fa-book"></i>Manage Users</a></li>
               <li><a href="ProductManagement.php"><i class="fas fa-book"></i>Manage Product</a></li>
               <li><a href="SupplierManagement.php"><i class="fas fa-home"></i>Manage Suppliers</a></li>
               <li><a href="OrderManagement.php"><i class="bi bi-receipt-cutoff"></i>orders</a></li>
               <li><a href=""><i class="fas fa-user"></i>#</a></li>
               <li><a href=""><i class="fas fa-user"></i>#</a></li>
               <li><a href=""><i class="fas fa-envelope"></i>About Us</a></li>
               <li><a href="logout.php">Log Out</a></li>
               <h4><span style="color:goldenrod ;"><?php echo     $_SESSION['admin_name'] ?></span></h4>
            </ul>
           
         </nav>
      </div>
               

   </body>


</html>

