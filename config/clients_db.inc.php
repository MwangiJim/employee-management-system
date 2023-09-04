<?php
 $conn = mysqli_connect('localhost','jimmy','test123','crud_app');
 if(!$conn){
   echo 'Error connecting to Database' . mysqli_connect_error();
 }
?>