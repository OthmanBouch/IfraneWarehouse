 <?php

@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:ManageUsers.php');
}



if(isset($_POST['submit'])){

    $Fname = $_POST['Fname'];
    $Lname = $_POST['Lname'];
    $Email = $_POST['Email'];
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);
    
 
    $select = " SELECT * FROM users WHERE Email = '$Email' && password = '$pass' ";
 
    $result = mysqli_query($conn, $select);
 
    if(mysqli_num_rows($result) > 0){
 
       $error[] = 'user already exist!';
 
    }else{
 
       if($pass != $cpass){
          $error[] = 'password not matched!';
       }else{
          $insert = "INSERT INTO users (Fname, Lname, Email, password) VALUES('$Fname','$Lname','$Email','$pass')";
          mysqli_query($conn, $insert);
          header('location:ManageUsers.php');
       }
    }
 
 };

 

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>User Page</title>
      <link rel="stylesheet" href="css/style3.css">
      <link rel="stylesheet" href="css/style.css">
      <link rel="shortcut icon" type="x-icon" href="AppFavicon.png">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  
   </head>
   
   <body style="background: url(LogInImage.jpg);background-repeat: no-repeat;background-size: 100%;">
    <h3>hello</h3>
    <?php
                    @include 'config.php';
                    
                    #here i should get the id from update_user.php
                    $id = $_SESSION['update_id'];

                    echo $id;?>
    
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
               <li><a href="ManageUsers.php"><i class="fas fa-book"></i>Manage Users</a></li>
               <li><a href=""><i class="fas fa-book"></i>#</a></li>
               <li><a href=""><i class="fas fa-home"></i>#</a></li>
               <li><a href=""><i class="fas fa-home"></i>#</a></li>
               <li><a href=""><i class="fas fa-user"></i>#</a></li>
               <li><a href=""><i class="fas fa-user"></i>#</a></li>
               <li><a href=""><i class="fas fa-envelope"></i>About Us</a></li>
               <li><a href="">Log Out</a></li>
               <h4><span style="color:goldenrod ;"><?php echo     $_SESSION['admin_name'] ?></span></h4>
            </ul>
           
         </nav>
      </div>
     <!-- to adjust view a bit down since it it with the hover thing --> 
    
      <br>
      <br>
      <br>
      
      <H3 style="text-align: center; margin: 0; color: brown; font-family: 'Helvetica', sans-serif; font-size: 24px; font-weight: bold; text-transform: uppercase; text-shadow: 2px 2px 4px rgba(165, 42, 42, 0.5);">List of Users</H3>

      <br>
      <br>

      <p><kbd> Search for user </kbd> <input class="form-control" id="myInput" type="text" placeholder="Search.."></p>

      <table class="table table-hover table-light">

  <thead>

    <tr>

      <th scope="col" style="text-shadow: 5px 5px 10px orange;">ID</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">First name</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Last name</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Email</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">User Type</th>
      <th scope="col" style="text-shadow: 5px 5px 10px orange;">Creation date</th>
      
      
    </tr>
  </thead>
 

  <tbody id="myTable">
<?php
$sql="Select ID, Fname, Lname, Email, user_type, Created from `users` where user_type = 'User' ";
$result=mysqli_query($conn,$sql);
if($result){
  while($row=mysqli_fetch_assoc($result)){
    $ID=$row['ID'];
    $Fname=$row['Fname'];
    $Lname=$row['Lname'];
    $Email=$row['Email'];
    $user_type=$row['user_type'];
    $Created=$row['Created'];
    
     echo '<tr>

     <th scope="row">'.$ID.'</th>
     <td>'.$Fname.'</td>
     <td>'.$Lname.'</td>
     <td>'.$Email.'</td>
     <td>'.$user_type.'</td>
     <td>'.$Created.'</td>
     <td>
     
     <button type="button" class="btn btn-link edit_data"><a href="#">Update User</a></button>
     <button type="button" class="btn btn-warning"><a href="delete_user.php? deleteID='.$ID.'">Delete User</a></button>
     </td>
   </tr>';
    
   

  }
 
}



?>

  </tbody>
</table>       
      <!-- jquery search code from a table  -->
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
      /* edit user*/ 
$(document).ready(function(){
  $('edit_data').click(function(e) {
    e.preventDefault();

    var user_id = $(this).closest('tr').find('.user_id').val();
    console.log(user_id);
    $.ajax({
    method:"POST",
    url:"code.php",
    data:{
    'click_edit_btn':true,
    'user_id':user_id,
    },
    success: function(response){
      $('#editdata').modal('show');
    }
        });

    });
});



</script>






















<!-- Add user Modal -->
<div class="modal fade" id="AddUser" tabindex="-1" aria-labelledby="AddUserLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="AddUserLabel text-align:center">Add User Credentials</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<form class="row g-3" method="post" action="">
  <div class="col-md-6">
    <label for="inputtext" class="form-label">First Name</label>
    <input type="text" name="Fname" class="form-control">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Last Name</label>
    <input type="text" name="Lname" class="form-control" >
  </div>
  <div class="col-12">
    <label for="inputAddress" class="form-label">Email</label>
    <input type="email" name="Email" class="form-control"  placeholder="Email">
  </div>
  <div class="col-md-6">
    <label for="inputAddress2" class="form-label">Password</label>
    <input type="password" name="password" class="form-control"  placeholder="Password">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Confirm password</label>
    <input type="password" name="cpassword" class="form-control"  placeholder="Password">
  </div>
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-warning">Save changes</button>
      </div>
</form>
      </div>
      
    </div>
  </div>
</div>
<!-- Add user Modal -->

<!-- Update user Modal -->
<div class="modal fade" id="editdata" tabindex="-1" aria-labelledby="AddUserLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="AddUserLabel text-align:center">Add User Credentials</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<form class="row g-3" method="post" action="">
  <div class="col-md-6">
    <label for="inputtext" class="form-label">First Name</label>
    <input type="text" name="Fname" class="form-control">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Last Name</label>
    <input type="text" name="Lname" class="form-control" >
  </div>
  <div class="col-12">
    <label for="inputAddress" class="form-label">Email</label>
    <input type="email" name="Email" class="form-control"  placeholder="Email">
  </div>
  <div class="col-md-6">
    <label for="inputAddress2" class="form-label">Password</label>
    <input type="password" name="password" class="form-control"  placeholder="Password">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Confirm password</label>
    <input type="password" name="cpassword" class="form-control"  placeholder="Password">
  </div>
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-warning">Save changes</button>
      </div>
</form>
      </div>
      
    </div>
  </div>
</div>
<!-- Update user Modal -->











































<!-- Button add user under user table -->
<div style="text-align: center;">
  <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#AddUser">
    Add a User
  </button>
</div>




   </body>





   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  

</html> 
