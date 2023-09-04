<?php
include '../config/clients_db.inc.php';

$name =$email=$phone=$address=$profession='';
//echo $_GET['id'];

//echo $id;
//$id_to_update = $_GET['id'];
//echo $id_to_update;
$sql_fetch = 'SELECT id,name,email,phonenumber,profession,address FROM clients';

$res_query = mysqli_query($conn,$sql_fetch);

$clients = mysqli_fetch_all($res_query,MYSQLI_ASSOC);

if(isset($_POST['submit-update'])){
    if(empty($_POST['name']) || empty($_POST['email'])||empty($_POST['phone']) || empty($_POST['address']) || empty($_POST['profession'])){
        header('Location:./edit.php?error=emptyFields');
    }
    else{
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $profession = $_POST['profession'];

        if(!preg_match('/^[a-zA-Z]/',$name)){
            header('Location:./edit.php?error=incorrectNameFormat&email='.$email.'&address ='.$profession);
            exit();
        }
        else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            header('Location:./edit.php?error=EmailFormatIncorrect&name ='.$name.'&profession = '.$profession);
            exit();
        }
        else if(!preg_match('/^[0-9]/',$phone)){
            header('Location:./edit.php?error=InvalidphoneFormat&email='.$email.'&address='.$profession);
            exit();
        }
        else if(!preg_match('/^[a-zA-Z0-9]/',$address)){
            header('Location:./add.php?error=InvalidAddress');
            exit();
        }
        else if(!preg_match('/^[a-zA-Z]/',$profession)){
            header('Location:./add.php?error=InvalidprofessionName');
            exit();
        }
        else{
            $email = mysqli_real_escape_string($conn,$email);
            $name = mysqli_real_escape_string($conn,$name);
            $phone = mysqli_real_escape_string($conn,$phone);
            $address = mysqli_real_escape_string($conn,$address);
            $profession = mysqli_real_escape_string($conn,$profession);

            $id_to_update = $_GET['updateid'];
            $sql = "UPDATE clients SET id = $id_to_update,name = '$name',email='$email',
            phonenumber=$phone,address='$address',profession='$profession' WHERE id = $id_to_update";

            if(!mysqli_query($conn,$sql)){
                header('Location:./edit.php?error=ErrorUpdatingServer');
                echo mysqli_error($conn);
                die();
            }
            else{
                header('Location:../index.php?success=true&id:'.$id_to_update.'updated');
                exit();
            }
            mysqli_close($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../styles.css"/>
</head>
<body>
<section class="add_clients_form">
        <h2>Add Client Records</h2>
          <form action="./edit.php" method="POST">
           <input name="name" type="text" placeholder="Client Name" value='<?php echo htmlspecialchars($name)?>'/>
           <input name="email" type="email" placeholder="Email Address" value='<?php echo htmlspecialchars($email) ?>'/>
           <input name="phone" type="number" placeholder="Phone Number" value='<?php echo htmlspecialchars($phone)?>'/>
           <input name="address" type="text" placeholder="Address Location" value='<?php echo htmlspecialchars($address)?>'/>
           <input name="profession" type="text" placeholder="Profession" value='<?php echo htmlspecialchars($profession)?>'/>
           <button type="submit" name="submit-update">Update Record</button>
           </form>
    </section>
</body>
</html>