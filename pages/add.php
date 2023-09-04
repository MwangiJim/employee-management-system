<?php
  include '../config/clients_db.inc.php';
$name =$email=$address=$profession=$phone = '';
 if(isset($_POST['submit'])){
    if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['address']) || empty($_POST['profession'])){
        header('Location:./add.php?error=missingInputFields');
        exit();
    }
    else{
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $name = $_POST['name'];
        $profession =  $_POST['profession'];
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            header('Location:./add.php?error=InvalidEmail&name = '.$name);
            exit();
        }
        else if(!preg_match('/[0-9]/',$phone)){
            header('Location:./add.php?error=InvalidphoneNumber&email = '.$email.'&address ='.$address);
            exit();
        }else if(!preg_match('/^[a-zA-Z]/',$name)){
            header('Location:./add.php?error=capitalizeName&email='.$email.'&profession =' .$profession);
            exit();
        }else if(!preg_match('/^[a-zA-Z]/',$profession)){
            header('Location:./add.php?error=InvalidprofessionName');
            exit();
        }else if(!preg_match('/^[a-zA-Z0-9]/',$address)){
            header('Location:./add.php?error=InvalidAddress');
            exit();
        }
        else{
           $email = mysqli_real_escape_string($conn,$email);
           $phone = mysqli_real_escape_string($conn,$phone);
           $address = mysqli_real_escape_string($conn,$address);
           $name = mysqli_real_escape_string($conn,$name);
           $profession = mysqli_real_escape_string($conn,$profession);

           $sql = "INSERT INTO clients(name,email,phonenumber,address,profession) VALUES('$name','$email','$phone','$address','$profession')";

           if(mysqli_query($conn,$sql)){
            header('Location:../index.php?success=true');
            exit();
           }else echo 'Error Inserting into database' . mysqli_error($conn);
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
        <form action="./add.php" method="POST">
           <input name="name" type="text" placeholder="Client Name" value='<?php echo htmlspecialchars($name) ?>'/>
           <input name="email" type="email" placeholder="Email Address" value='<?php echo htmlspecialchars($email) ?>'/>
           <input name="phone" type="number" placeholder="Phone Number" value='<?php echo htmlspecialchars($phone) ?>'/>
           <input name="address" type="text" placeholder="Address Location" value='<?php echo htmlspecialchars($address) ?>'/>
           <input name="profession" type="text" placeholder="Profession" value='<?php echo htmlspecialchars($profession) ?>'/>
           <button type="submit" name="submit">Save Client</button>
        </form>
    </section>
</body>
</html>