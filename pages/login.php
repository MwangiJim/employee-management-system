<?php
include '../config/clients_db.inc.php';

$email = $password = '';
if(isset($_POST['submit-login'])){
    if(empty($_POST['email']) || empty($_POST['pwd'])){
        header('Location:./login.php?error=MissingFields');
        exit();
    }
    else{
        $email = $_POST['email'];
        $password =  $_POST['pwd'];

        $sql = "SELECT id,email,password FROM users where email = '$email'";
        $res = mysqli_query($conn,$sql);

        $user_info = mysqli_fetch_assoc($res);
         print_r($user_info);
        if(!$user_info){
          header('Location:./login.php?error=UserNotFound');
          exit();
        }
        else if(!password_verify($password,$user_info['password'])){
          header(('Location:./login.php?error=WrongPassword'));
        }
        else{
          session_start();
          $_SESSION['session_id'] = $user_info['email'];
          header('Location:./index.php?login=true');
          exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   
<link rel="stylesheet" href="../styles.css"/>
<style>
    .login-form form{
        width:450px;
    height:max-content;
    top:50%;
    left:50%;
    position: absolute;
    transform: translate(-50%,-50%);
    background-color: #fdfdfd;
    border-radius: 5px;
    padding: 8px 5px;
    }
    .login-form h2{
        text-align: center;
    }
    .login-form  form .input{
        height:50px;
    width:95%;
    border-radius: 10px;
    padding: 0 10px;
    margin:2% 0;
    outline: none;
    border:1px solid #000;
    }
    .login-form  form .input:focus{
        border:2px solid green;
    }
    .login-form form button{
    background-color: #4315e9;
    border: none;
    padding:12px 40px;
    outline: none;
    border-radius: 5px;
    color: #fdfdfd;
    width: 100%;
    cursor: pointer;
    margin: 2% 0;
}
</style>
</head>
<body>
    <section class="login-form">
        <h2>Login</h2>
        <form action="./login.php" method="POST">
            <label>Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email)?>" class="input">
            <label>Password</label>
            <input type="password" name="pwd" value="<?php echo htmlspecialchars($password)?>" class="input">
            <br/>
            <input type="checkbox">
            <label>Stay logged in for 30 days</label>
            <br/>
            <button type="submit" name="submit-login">Login</button>
           <p>No Account!<a href="./register.php">Register</a></p>
        </form>
    </section>
</body>
</html>