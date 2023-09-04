<?php
 // include './pages/add.php';
session_start();
include './config/clients_db.inc.php';

 $sql = 'SELECT id,name,email,phonenumber,address,profession FROM clients';

 $res_query = mysqli_query($conn,$sql);

 $clients = mysqli_fetch_all($res_query,MYSQLI_ASSOC);

 $users_sql = 'SELECT id,name,email FROM user';

 $res = mysqli_query($conn,$users_sql);

 $user = mysqli_fetch_row($res);
 //print_r($res);
//free result
// mysqli_free_result($res_query);
// mysqli_close($conn);
 //$id = 0;
 //print_r($clients);
// //delete record
if(isset($_SESSION['id'])){
  if($_SESSION['id'] === $user['id']){
    '<div class="container">
   <div class="head">
        <a href="./pages/add.php" class="btn">New Client</a>
    </div>
    <div class="list">
        <div class="list_header">
            <div>ID</div>
            <div>Name</div>
            <div>Email</div>
            <div>Phone</div>
            <div>Address</div>
            <div>Profession</div>
            <div>Action</div>
        </div>
        <div class="clients">
            <?php foreach($clients as $client){?>
                <div class="client">
                    <div><?php  echo htmlspecialchars($client["id"])?></div>
                    <div><?php echo htmlspecialchars($client["name"])?></div>
                    <div><?php echo htmlspecialchars($client["email"])?></div>
                    <div><?php echo htmlspecialchars($client["phonenumber"])?></div>
                    <div><?php echo htmlspecialchars($client["address"])?></div>
                    <div><?php echo htmlspecialchars($client["profession"])?></div>
                    <a href="./pages/edit.php?updateid=<?php echo $client["id"]?>" class="edit">Edit</a>
                     <form action="./pages/delete.php" method="POST">
                        <input type="hidden" name="id-to-delete" value="<?php echo $client["id"]?>">
                        <input type="submit" name="delete" value="Delete" class="red">
                     </form>
                </div>
             <?php }?>
        </div>
    </div>
</div>';
  }
}else{
    echo 'You are not logged in';
    include './pages/login.php';
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud App in Php</title>
    <link rel="stylesheet" href="styles.css"/>
</head>
<body>
    
</body>
</html>