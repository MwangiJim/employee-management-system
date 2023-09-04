<?php
 include '../config/clients_db.inc.php';
 $email=$name=$password=$verify_pwd='';

 if(isset($_POST['submit'])){
    if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['pwd']) || empty($_POST['verify_pwd'])){
      header('Location:./register.php?error=MissingInputFields');
      exit();
    }
    else{
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['pwd'];
        $verify_pwd = $_POST['verify_pwd'];

        if(!preg_match('/^[a-zA-Z]/',$name)){
            header('Location:./register.php?error=IncorrectNameFormat&email= ' . $email);
            exit();
        }
        else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            header('Location:./register.php?error=InvalidEmailFormat&name='.$name);
            exit();
        }
        else if($password !== $verify_pwd){
            header('Location:./register.php?error=PasswordMismatch&name=' . $name .'&email = '.$email);
            exit();
        }
        else{
            $name = mysqli_real_escape_string($conn,$name);
            $email = mysqli_real_escape_string($conn,$email);
            $password = mysqli_real_escape_string($conn,$password);
            $hashPwd = password_hash($password,PASSWORD_DEFAULT);
             //create account
            $sql = "INSERT INTO user(name,email,password) VALUES('$name','$email','$hashPwd')";
             //fetch all existing users
            $sql_users = "SELECT email FROM user";

            $res_sql_users = mysqli_query($conn,$sql_users);

            $users = mysqli_fetch_all($res_sql_users,MYSQLI_ASSOC);
            foreach($users as $user){
                if($email === $user['email']){
                    header('Location:./register.php?error=UserAlreadyExists');
                    exit();
                }
                else{
                    if(mysqli_query($conn,$sql)){
                        header('Location:./login.php?success=true&register=true');
                        session_start();
                        exit();
                    }else{
                        header('Location:./register.php?error=ErrorCreatingAccount');
                        exit();
                        die(mysqli_close($conn));
                    }
                }
            }
        }
    }
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../styles.css"/>
 <style>
    .register_form{
    width:100%;
    height: 100vh;
}
.register_form form{
    width:450px;
    height:max-content;
    top:50%;
    left:50%;
    position: absolute;
    transform: translate(-50%,-50%);
    background-color: #fdfdfd;
    border-radius: 5px;
    padding: 8px 5px;
    box-shadow: 3px 3px 7px #000;
}
.register_form form input{
    height:50px;
    width:95%;
    border-radius: 25px;
    padding: 0 10px;
    margin:2% 0;
    outline: none;
    border:1px solid #000;
}
.register_form form input:focus{
    border: 2px solid green;
}
.register_form form button{
    background-color: #000;
    border: none;
    padding:12px 40px;
    outline: none;
    border-radius: 10px;
    color: #fdfdfd;
    cursor: pointer;
}
.register_form h2{
    text-align: center;
}
 </style>
</head>
<body>
    <section class="register_form">
         <h2>Register</h2>
        <form action="./register.php" method="POST">
            <label>Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($name)?>">
            <label>Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email)?>">
            <label>Password</label>
            <input type="password" name="pwd" value="<?php echo htmlspecialchars($password)?>">
            <label>Reenter Password
            <input type="password" name="verify_pwd">
            <button type="submit" name="submit">Create Account</button>
            <p>Already have an account?<a href="./login.php">Login</a></p>
        </form>
    </section>
</body>
</html>