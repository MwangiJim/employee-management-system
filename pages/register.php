<?php
 include '../config/clients_db.inc.php';
 $email=$name=$password=$verify_pwd=$msgError='';

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
            $sql = "INSERT INTO users(name,email,password) VALUES('$name','$email','$hashPwd')";
             //fetch all existing users
            $sql_users = "SELECT id,name,email FROM users";

            $res_sql_users = mysqli_query($conn,$sql_users);

            $users = mysqli_fetch_array($res_sql_users,MYSQLI_ASSOC);
            print_r($users);
                if($email === $users['email']){
                    header('Location:./register.php?error=UserAlreadyExists');
                    $msgError = 'User Already Exists';
                    exit();
                }
                else{
                    if(mysqli_query($conn,$sql)){
                        header('Location:./index.php?success=true&register=true');
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../styles.css"/>
 <style>
    .register_form{
    width:100%;
    height: 100vh;
    display: flex;
    justify-content: space-between;
}
.left_form{
    flex-basis: 60%;
    height: 100vh;
    background-color: #4315e9;
    color: #fff;
}
.left_form h3{
    text-align: center;
    margin: 20px 0;
    font-size: 25px;
}
.left_form .left_form_box{
    display: flex;
    justify-content: space-between;
    text-align: left;
    margin: 40px 0;
}
.left_form_box li{
    padding: 10px 20px;
    font-size: 18px;
}
.right_form{
    flex-basis: 40%;
    height: 100vh;
}
.register_form form{
    width:450px;
    height:max-content;
    background-color: #fdfdfd;
    border-radius: 5px;
    padding: 8px 5px;
}
.register_form form input{
    height:50px;
    width:95%;
    border-radius: 10px;
    padding: 0 10px;
    margin:2% 0;
    outline: none;
    border:1px solid #000;
}
.register_form form input:focus{
    border: 2px solid green;
}
.register_form form button{
    background-color: #4315e9;
    width: 100%;
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
        <div class="left_form">
             <h3>Employee Work Management and Administration System</h3>
             <div class="left_form_box">
                <div class="l_box">
                    <h2>ADMIN</h2>
                    <li>Information Management</li>
                    <li>Employee Manager</li>
                    <li>HRM</li>
                    <li>Workflow Management</li>
                    <li>Salary and Discipline management</li>
                    <li>Time Attendance management</li>
                    <li>Send Email,notification letter</li>
                </div>
                <div class="r_box">
                <h2>ADMIN</h2>
                    <li>Information Management</li>
                    <li>Employee Manager</li>
                    <li>HRM</li>
                    <li>Workflow Management</li>
                    <li>Salary and Discipline management</li>
                    <li>Time Attendance management</li>
                    <li>Send Email,notification letter</li>
                </div>
             </div>
        </div>
       <div class="right_form">
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
            <p>Already have an account?<a href="./index.php">Login</a></p>
        </form>
       </div>
    </section>
</body>
</html>