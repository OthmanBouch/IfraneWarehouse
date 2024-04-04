<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login.php');
}else {
   $adminID = $_SESSION['admin_ID'];
}
if (isset($_POST['submit'])) {
   $productID = $_POST['product'];
   $supplierID = $_POST['supplier'];
   $quantityOrdered = $_POST['quantity'];
   $createdBy = $adminID;

   // You can perform any necessary validation here before inserting the order into the database

   $insertOrder = "INSERT INTO product_supplier (S_id, P_id, quantity_ordered, Created_by) 
                   VALUES ('$supplierID', '$productID', '$quantityOrdered', '$createdBy')";
   mysqli_query($conn, $insertOrder);
   header('location:OrderManagement.php'); // Redirect after insertion
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Orders  Page</title>
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
      <br>
    <br>
    <br>

    <H3 style="text-align: center; margin: 0; color: brown; font-family: 'Helvetica', sans-serif; font-size: 24px; font-weight: bold; text-transform: uppercase; text-shadow: 2px 2px 4px rgba(165, 42, 42, 0.5);">List of Orders</H3>

    <br>
    <p><kbd> Search for orders </kbd> <input class="form-control" id="myInput" type="text" placeholder="Search.."></p>

    <table class="table table-light table-hover table-striped table-bordered ">
        <thead>
            <tr>
                <th scope="col" style="text-shadow: 5px 5px 10px orange;">ID</th>
                <th scope="col" style="text-shadow: 5px 5px 10px orange;">Product Name</th>
                <th scope="col" style="text-shadow: 5px 5px 10px orange;">Supplier</th>
                <th scope="col" style="text-shadow: 5px 5px 10px orange;">Quantity</th>
                <th scope="col" style="text-shadow: 5px 5px 10px orange;">Created By (ID)</th>
                <th scope="col" style="text-shadow: 5px 5px 10px orange;">Date of Creation</th>
                <th scope="col" style="text-shadow: 5px 5px 10px orange;">View</th>
                <th scope="col" style="text-shadow: 5px 5px 10px orange;">Update</th>
                <th scope="col" style="text-shadow: 5px 5px 10px orange;">Delete</th>

            </tr>
        </thead>
        <tbody id="myTable">
            <?php
            @include 'config.php';
            $fetch_query = "SELECT * FROM orders";
            $fetch_query_run = mysqli_query($conn, $fetch_query);

            if (mysqli_num_rows($fetch_query_run) > 0) {
                while ($row = mysqli_fetch_array($fetch_query_run)) {
                    ?>
                    <tr>

                        <td class="order_id"><?php echo $row['ID']; ?></td>
                        <td><?php
                            $productID = $row['P_id'];
                            $productQuery = "SELECT Pname FROM products WHERE ID = '$productID'";
                            $productResult = mysqli_query($conn, $productQuery);
                            $productName = mysqli_fetch_array($productResult)['Pname'];
                            echo $productName;
                            ?>
                        </td>
                        <td><?php
                            $supplierID = $row['S_id'];
                            $supplierQuery = "SELECT Sname FROM supplier WHERE ID = '$supplierID'";
                            $supplierResult = mysqli_query($conn, $supplierQuery);
                            $supplierName = mysqli_fetch_array($supplierResult)['Sname'];
                            echo $supplierName;
                            ?>
                        </td>
                        <td><?php echo $row['quantity_ordered']; ?></td>
                        <td><?php echo $row['Created_by']; ?></td>
                        <td><?php echo $row['Created_at']; ?></td>
                        <td>
                            <form action="view_order.php" method="POST">
                                <input type="hidden" name="view_id" value="<?php echo $row['ID']; ?>">
                                <button type="submit" name="view_btn" class="btn btn-success">VIEW</button>
                            </form>
                        </td>
                        <td>
                            <form action="update_order.php" method="POST">
                                <input type="hidden" name="update_id" value="<?php echo $row['ID']; ?>">
                                <button type="submit" name="update_btn" class="btn btn-warning">UPDATE</button>
                            </form>
                        </td>
                        <td>
                            <form action="code.php" method="POST">
                                <input type="hidden" name="delete_id" value="<?php echo $row['ID']; ?>">
                                <button type="submit" name="delete_btn" class="btn btn-danger">DELETE</button>
                            </form>
                        </td>

                    </tr>
            <?php
                }
            } else {
                echo "No Record Found";
            }
            ?>
        </tbody>
    </table>
    <br>

    <!-- Button to add order -->
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#AddOrder">
        Add an Order
    </button>

    <!-- Add Order Modal -->
    <div class="modal fade" id="AddOrder" tabindex="-1" aria-labelledby="AddOrderLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="AddOrderLabel text-align:center">Add Order Information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" method="post" action="">
                        <div class="col-md-12">
                            <label for="product" class="form-label">Select Product</label>
                            <select class="form-select" name="Pname">
                                <?php
                                @include 'config.php';
                                $fetch_query = "SELECT * FROM products";
                                $fetch_query_run = mysqli_query($conn, $fetch_query);

                                if (mysqli_num_rows($fetch_query_run) > 0) {
                                    while ($row = mysqli_fetch_array($fetch_query_run)) {
                                        ?>
                                        <option value="<?php echo $row['ID']; ?>"><?php echo $row['Pname']; ?></option>
                                <?php
                                    }
                                } else {
                                    echo "No Record Found";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="supplier" class="form-label">Select Supplier</label>
                            <select class="form-select" name="supplier">
                                <?php
                                @include 'config.php';
                                $fetch_query = "SELECT * FROM supplier";
                                $fetch_query_run = mysqli_query($conn, $fetch_query);

                                if (mysqli_num_rows($fetch_query_run) > 0) {
                                    while ($row = mysqli_fetch_array($fetch_query_run)) {
                                        ?>
                                        <option value="<?php echo $row['ID']; ?>"><?php echo $row['Sname']; ?></option>
                                <?php
                                    }
                                } else {
                                    echo "No Record Found";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-warning">Add Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>    

   </body>


</html>

