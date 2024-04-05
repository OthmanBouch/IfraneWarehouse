<?php 
session_start();
$conn = mysqli_connect('localhost','root','','inventory');
/*---------------------------------------------------------User Area---------------------------------------------------------------- */
/* view user*/ 
if(isset($_POST['click_view_btn']))
{
    $id = $_POST['user_id'];
   
   $fetch_query = "SELECT * FROM users where id='$id'";
    $fetch_query_run = mysqli_query($conn,$fetch_query);

    if(mysqli_num_rows($fetch_query_run) > 0){
        while($row = mysqli_fetch_array($fetch_query_run))
        {
            echo '
            <h6>User ID:  '.$row['ID'].'</h6>
            <h6>First Name:  '.$row['Fname'].'</h6>
            <h6>Last Name:  '.$row['Lname'].'</h6>
            <h6>Email:  '.$row['Email'].'</h6>
            <h6>Creation Date:  '.$row['Created'].'</h6>
            ';
        }
    }else{
        echo '<h4> no record found</h4>';
    }
}

/*show record to update user*/
if(isset($_POST['click_edit_btn']))
{
    $id = $_POST['user_id'];
    $arrayresult = [];
   $fetch_query = "SELECT * FROM users where id='$id'";
    $fetch_query_run = mysqli_query($conn,$fetch_query);

    if(mysqli_num_rows($fetch_query_run) > 0){
        while($row = mysqli_fetch_array($fetch_query_run))
        {
           array_push($arrayresult, $row);
           header('content-type: application/json');
           echo json_encode($arrayresult);
        }
    }else{
        echo '<h4> no record found</h4>';
    }
}
/* update user*/ 
if(isset($_POST['updates_data']))
{
    $id = $_POST['id'];
    $Fname = $_POST['Fname'];
    $Lname = $_POST['Lname'];
    $Email = $_POST['Email'];

    $update_query = "UPDATE users SET Fname='$Fname', Lname='$Lname', Email='$Email' WHERE ID = '$id'";
    $update_query_run = mysqli_query($conn,$update_query);

    if($update_query_run){
        $_SESSION['status'] = 'data updated successfully';
        header("location:UserManagement.php");
    }else{
        $_SESSION['status'] = 'data not updated successfully';
        header("location:UserManagement.php");
    }
}

/* Delete user */
if(isset($_POST['click_delete_btn'])){
    $id = $_POST['user_id'];

    $delete_query = "DELETE FROM users WHERE id = '$id'";
    $delete_query_run = mysqli_query($conn,$delete_query);  

    if($delete_query_run){
        echo "data deleted successfully";
    }else{
        echo "problem occured; skill issue";
    }
}

/*---------------------------------------------------------Product Area---------------------------------------------------------------- */
/* view product*/
if(isset($_POST['click_viewprod_btn']))
{
    $IDs = $_SESSION['admin_ID'];
    $id = $_POST['prod_id'];
   
   $fetch_query = "SELECT * FROM products where id='$id'";
    $fetch_query_run = mysqli_query($conn,$fetch_query);
    
    if(mysqli_num_rows($fetch_query_run) > 0){
        while($row = mysqli_fetch_array($fetch_query_run))
        {
            echo '
            <h6>Product ID:  '.$row['ID'].'</h6>
            <h6>Product Image:   </h6>
                <div class="text-center">
            <img src="images/' . $row['img'] . '" alt="Product Image" style="max-width: 300px; max-height: 500px;">
                </div>
            <h6>Product Name:  '.$row['Pname'].'</h6>
            <h6>Product Type:  '.$row['Ptype'].'</h6>
            <h6>Author Name:  '.$IDs.'</h6>
            <h6>Description:  '.$row['Description'].'</h6>
            
            ';
        }
    }else{
        echo '<h4> no record found</h4>';
    }
} 

/* Delete product */
if(isset($_POST['click_prod_delete_btn'])){
    $id = $_POST['prod_id'];
    // we should delete the product from the bridge table first before deleting it from product table
    //or else we get foreing key checks problem
    $delete_queryy = "DELETE FROM productswsuppliers WHERE product = '$id'";
    $delete_queryy_run = mysqli_query($conn,$delete_queryy);  
    
    $delete_query = "DELETE FROM products WHERE ID = '$id'";
    $delete_query_run = mysqli_query($conn,$delete_query);  

    if($delete_query_run){
        echo "product deleted successfully";
    }else{
        echo "problem occured, sounds like a skill issue to me bozo";
    }
}

/*show record to update product*/
if(isset($_POST['click_editprod_btn']))
{
    $id = $_POST['prod_id'];
    $arrayresult = [];
   $fetch_query = "SELECT * FROM products where ID ='$id'";
    $fetch_query_run = mysqli_query($conn,$fetch_query);

    if(mysqli_num_rows($fetch_query_run) > 0){
        while($row = mysqli_fetch_array($fetch_query_run))
        {
           array_push($arrayresult, $row);
           header('content-type: application/json');
           echo json_encode($arrayresult);
        }
    }else{
        echo '<h4> no record found</h4>';
    }
}

/* update product*/ 
if(isset($_POST['updates_product']))
{
    $id = $_POST['id'];
   
    $Pname = $_POST['Pname'];
    $Ptype = $_POST['Ptype'];
    $Description = $_POST['Description'];
    if (!empty($_POST['img'])) {
        // If a new image is selected, update the image 
        $img = $_POST['img'];
    } else {
        // If no new image is selected, keep the existing image path
        
        $existingImagePathQuery = "SELECT img FROM products WHERE ID = '$id'";
        $existingImagePathResult = mysqli_query($conn, $existingImagePathQuery);
        $existingImagePathRow = mysqli_fetch_assoc($existingImagePathResult);
        $img = $existingImagePathRow['img'];
    }

    $update_query = "UPDATE products SET img='$img', Pname='$Pname', Ptype='$Ptype', Description='$Description' WHERE ID = '$id'";
    $update_query_run = mysqli_query($conn,$update_query);
    
    //now we delete the supplier f prodwsupp table bach matjinash chi foreign key error
    $deleteAssociationsQuery = "DELETE FROM productswsuppliers WHERE product = '$id'";
    mysqli_query($conn, $deleteAssociationsQuery);
    // o hna we iterate between l values dyal suppliers li 3mrna f update form 
    foreach ($_POST['Suppliers'] as $supplierName) {
        $supplierIDQuery = "SELECT ID FROM supplier WHERE Sname = '$supplierName'";
        $supplierIDResult = mysqli_query($conn, $supplierIDQuery);

        if ($supplierIDResult && $row = mysqli_fetch_assoc($supplierIDResult)) {
            $supplierID = $row['ID'];

            // o hna we insert dok values f ProductWsuppliers table
            $bridgeQuery = "INSERT INTO productswsuppliers (supplier, product) VALUES ('$supplierID','$id')";
            mysqli_query($conn, $bridgeQuery);
        }
    
    }

    if($update_query_run){
        $_SESSION['status'] = 'product updated successfully';
        header("location:ProductManagement.php");
    }else{
        
        $_SESSION['status'] = 'product not updated successfully';
        header("location:ProductManagement.php");
    }
  
 
}

/*---------------------------------------------------------Supplier Area---------------------------------------------------------------- */

/* Delete supplier */
if(isset($_POST['click_Supp_delete_btn'])){
    $id = $_POST['supp_id'];
    // we should delete the supplier from the bridge table first before deleting it from supplier table
    //or else we get foreing key checks problem
    $delete_queryy = "DELETE FROM productswsuppliers WHERE supplier = '$id'";
    $delete_queryy_run = mysqli_query($conn,$delete_queryy);  
    
    $delete_query = "DELETE FROM supplier WHERE ID = '$id'";
    $delete_query_run = mysqli_query($conn,$delete_query);  

    if($delete_query_run){
        echo "supplier deleted successfully";
    }else{
        echo "problem occured, sounds like a skill issue to me bozo";
    }
}

/* view supplier */
if(isset($_POST['click_viewsupp_btn']))
{
    $id = $_POST['supp_id'];
   
   $fetch_query = "SELECT * FROM supplier where ID='$id'";
    $fetch_query_run = mysqli_query($conn,$fetch_query);
    
    if(mysqli_num_rows($fetch_query_run) > 0){
        while($row = mysqli_fetch_array($fetch_query_run))
        {
            echo '
            <h6>Supplier name:  '.$row['Sname'].'</h6>
            <h6>Supplier location:  '.$row['Slocation'].'</h6>
            <h6>Supplier contact (Email):  '.$row['Email'].'</h6>
            <h6>Creation date:  '.$row['Created'].'</h6>
            
            
            ';
        }
    }else{
        echo '<h4> no record found</h4>';
    }
} 

/* show record to update supplier */
if(isset($_POST['click_editsupp_btn']))
{
    $id = $_POST['supp_id'];
    $arrayresult = [];
    $fetch_query = "SELECT * FROM supplier where ID ='$id'";
    $fetch_query_run = mysqli_query($conn,$fetch_query);

    if(mysqli_num_rows($fetch_query_run) > 0){
        while($row = mysqli_fetch_array($fetch_query_run))
        {
           array_push($arrayresult, $row);
           header('content-type: application/json');
           echo json_encode($arrayresult);
        }
    }else{
        echo '<h4> no record found</h4>';
    }
}

/* update supplier */ 
if(isset($_POST['updates_supplier']))
{
    $id = $_POST['id'];
    $Sname = $_POST['Sname'];
    $Slocation = $_POST['Slocation'];
    $Email = $_POST['Email'];

    $update_query = "UPDATE supplier SET Sname='$Sname', Slocation='$Slocation', Email='$Email' WHERE ID = '$id'";
    $update_query_run = mysqli_query($conn,$update_query);

    if($update_query_run){
        $_SESSION['status'] = 'data updated successfully';
        header("location:SupplierManagement.php");
    }else{
        $_SESSION['status'] = 'data not updated successfully';
        header("location:SupplierManagement.php");
    }
 
}
/*---------------------------------------------------------Order Area---------------------------------------------------------------- */
/* view order */


/* Delete order */
if(isset($_POST['click_order_delete_btn'])){
    $id = $_POST['order_id'];

    $delete_query = "DELETE FROM product_supplier WHERE id = '$id'";
    $delete_query_run = mysqli_query($conn,$delete_query);  

    if($delete_query_run){
        echo "data deleted successfully";
    }else{
        echo "problem occured; skill issue";
    }
}

?>