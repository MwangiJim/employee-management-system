<?php
include '../config/clients_db.inc.php';

if(isset($_POST['delete'])){
   $id_to_delete = $_POST['id-to-delete'];

   $sql = "DELETE FROM employees WHERE id = $id_to_delete";
   if(mysqli_query($conn,$sql)){
      header('Location:./index.php?success=true&deletedRecord id :' .$id_to_delete); 
      exit();
   }
   else{
      header('Location:./index.php?error=ErrorDeletingRecord');
      exit();
   }
}
mysqli_close($conn);
die();
?>