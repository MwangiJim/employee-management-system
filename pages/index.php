<?php
session_start();
include '../config/clients_db.inc.php';

 $users_sql = 'SELECT id,name,email FROM users';

 $res = mysqli_query($conn,$users_sql);

 $user = mysqli_fetch_row($res);
 //print_r($res);
 
 //get employeedetails

 $sql = "SELECT * FROM employees";
 $response = mysqli_query($conn,$sql);
 $employees = mysqli_fetch_all($response,MYSQLI_ASSOC);
 
// //delete record
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <link rel="stylesheet" href="../styles.css"/>
  <style>
     .container{
        width:100%;
        height: 100vh;
        top: 0;
        left: 0;
        position: absolute;
        background-color: #d3d3d3;
     }
     .head{
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 12px;
        background-color: #fff;
     }
     .container-body{
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
     }
     .left_body{
        flex-basis: 20%;
        background-color: #fff;
        border-radius: 7px;
        height: 90vh;
     }
     .right_body{
        flex-basis: 78%;
        background-color: #fff;
        border-radius: 7px;
        height: max-content;
        padding: 7px;
     }
     .left_body li{
        list-style: none;
        padding: 15px 12px;
        font-size: 18px;
     }
     .left_body li:hover{
        background-color: #4315e9;
        color: #fff;
        cursor: pointer;
     }
     .top_right_body{
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 5px;
     }
     .user-input-right{
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-basis: 50%;
     }
     .N-btn{
        padding: 7px 40px;
        color: #fff;
        border: none;
        outline: none;
        border-radius: 6px;
        cursor: pointer;
        background-color: green;
        text-decoration: none;
     }
     .search-btn{
        background-color: #4315e9;
        padding: 7px 30px;
        color: #fff;
        border: none;
        outline: none;
        border-radius: 6px;
        cursor: pointer;
     }
     .user-input-right input{
        width:250px;
        height: 30px;
        outline: none;
        border-radius: 6px;
     }
    .user-details-index{
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
    }
    .user-details-index div{
        margin: 0 7px;
        font-weight: bolder;
    }
    .one{
        flex-basis: 5%;
    }
    .two{
        flex-basis: 5%;
    }
    .three{
        flex-basis: 15%;
    }
    .four{
        flex-basis: 25%;
    }
    .five{
        flex-basis: 40%;
        display: flex;
        align-items: center;
        justify-content: left;
    }
    .five button{
        margin: 0 7px;
    }
    .list_array_box{
        height: max-content;
        width:100%;
    }
    .user_box{
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 10px 0;
        padding: 5px 0;
    }
    .user_box div{
        margin: 0 10px;
    }
    .user_box img{
        width:30px;
        height: 30px;
        border: 3px solid #000;
        border-radius: 7px;
        object-fit: cover;
    }
    .view_btn{
        padding: 7px 20px;
        color: #fff;
        border-radius: 7px;
        border: none;
        outline: none;
        cursor: pointer;
        background-color: #4315e9;
    }
    .edit_btn{
        padding: 5px 5px;
        width:50px;
        color: #fff;
        border-radius: 7px;
        border: none;
        outline: none;
        cursor: pointer;
        background-color: lightseagreen;
    }
    .delete_btn{
        padding: 5px 5px;
        width:60px;
        color: #fff;
        border-radius: 7px;
        border: none;
        outline: none;
        cursor: pointer;
        background-color: red;
    }
  </style>
</head>
<body>
<div class="container">
   <div class="head">
       <h1>ADMIN</h1> 
       <?php if (isset($_SESSION['session_id'])): ?>
            <form action="./logout.php" method="POST">
            <input type="submit" name="submit-logout" value="LOGOUT"/>
        </form>
        <?php endif?>
    </div>
    <?php if(isset($_SESSION['session_id'])): ?>
      <div class="container-body">
        <div class="left_body">
            <li>OverView</li>
            <li>List of Items</li>
            <li>Account Management</li>
            <li>Room Locations</li>
            <li>Salary Management</li>
            <li>WorkFlow Management</li>
            <li>Reward Discipline</li>
            <li>Account</li>
            <li>Identity Management</li>
            <li>Email Management</li>
        </div>
        <div class="right_body">
            <div class="top_right_body">
                <h3>List of Users</h3>
                <div class="user-input-right">
                <a href="./add.php" class="N-btn">New Client</a>
                <form>
                    <input type="text" name="search-info"/>
                </form>
                <button class="search-btn">Search</button>
                </div>
            </div>
            <div class="user-details-index">
                <div class="one">#</div>
                <div class="two">Code</div>
                <div class="two">Avatar</div>
                <div class="three">Name</div>
                <div class="one">Sex</div>
                <div class="three">Date of Birth</div>
                <div class="four">Place of Birth</div>
                <div class="three">ID number</div>
                <div class="five">Action</div>
            </div>
           <div class="list_array_box">
                <?php foreach($employees as $employee): ?>
                    <div class="user_box">
                        <div class="one"><?php echo htmlspecialchars($employee['id'])?></div>
                        <div class="two">EMP</div>
                        <img src="<?php echo $employee['profile_img_path'] ?>" alt="avatar_img" class="two"/>
                        <div class="three"><?php echo $employee['name']?></div>
                        <div class="one"><?php echo $employee['gender']?></div>
                        <div class="three"><?php echo $employee['date_of_birth']?></div>
                        <div class="four"><?php echo $employee['place_of_birth']?></div>
                        <div class="three"><?php echo $employee['id_number']?></div>
                        <div class="five">
                            <form action="./view.pages.php" method="POST">
                                <input name="id-to-view" type="hidden" value="<?php echo $employee['id']?>"/>
                                <button class="view_btn" name="view-detail">View Details</button>
                            </form>
                            <form action="./edit.php" method="POST">
                                <input type="hidden" name="id-to-edit" value="<?php echo $employee['id'] ?>"/>
                                 <button class="edit_btn" name="update-detail">Edit</button>
                            </form>
                            <form action="./delete.php" method="POST">
                                <input type="hidden" name="id-to-delete" value="<?php echo $employee['id'] ?>"/>
                                <button class="delete_btn" name="delete">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach ?>
              </div>
           </div>
        </div>
         <?php else :?>
            <?php echo 'Session Timed Out!'?>
            <?php include './login.php'?>
        <?php endif ?>
</div>
</body>
</html>