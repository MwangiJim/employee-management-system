<?php 
 include '../config/clients_db.inc.php';

 $id = '';
 if(isset($_POST['view-detail'])){
    $id = $_POST['id-to-view'];
    $sql = "SELECT * FROM employees WHERE id = $id";
    $res = mysqli_query($conn,$sql);
    $employee_detail = mysqli_fetch_assoc($res);
   // print_r($employee_detail);
   // header('Location:./view.pages.php?id='.$id);
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        *{
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }
        .details{
            width:100%;
            height: 100vh;
            top:0;
            left: 0;
            position: absolute;
            background-color: #d3d3d3;
        }
        .box{
           background-color: #fff;
           width:80%;
           height:85vh;
           display: flex;
           justify-content: space-between;
           left: 10%;
           position: absolute;
           border-radius: 10px;
           overflow: hidden;
        }
        .right-image{
            flex-basis: 40%;
        }
        .right-image img{
            width:400px;
            height: 400px;
            object-fit: cover;
        }
        .left-content{
            flex-basis: 60%;
        }
        .left-content h3{
            margin-left: 20px;
        }
        .details-box{
            display: flex;
            justify-content: space-between;
        }
        .left-details{
            flex-basis: 45%;
            text-align: left;
        }
        .right-details{
            flex-basis: 40%;
            text-align: left;
        }
    </style>
</head>
<body>
    <section class="details">
        <h1>View Employee <?php echo $id?></h1>
       <div class="box">
          <div class="right-image">
            <img src="<?php echo $employee_detail['profile_img_path'] ?>"/>
          </div>
          <div class="left-content">
             <h3>Details</h3>
            <div class="details-box">
                <div class="left-details">
                <p>Full Name : <?php echo htmlspecialchars($employee_detail['name'])?></p>
                <p>NickName : <?php echo htmlspecialchars($employee_detail['nickname'])?></p>
                <p>Sex : <?php echo htmlspecialchars($employee_detail['gender'])?></p>
                <p>Date of Birth : <?php echo htmlspecialchars($employee_detail['date_of_birth'])?></p>
                <p>Place of Birth : <?php echo htmlspecialchars($employee_detail['place_of_birth'])?></p>
                <p>Phone : <?php echo htmlspecialchars($employee_detail['phonenumber'])?></p>
                <p>Email : <?php echo htmlspecialchars($employee_detail['email'])?></p>
                <p>Marriage Status : <?php echo htmlspecialchars($employee_detail['marriage_status'])?></p>
                <p>ID Number : <?php echo htmlspecialchars($employee_detail['id_number'])?></p>
                <p>Passport Expiry Date : <?php echo htmlspecialchars($employee_detail['passport_expiry_date'])?></p>
                <p>Nationality : <?php echo htmlspecialchars($employee_detail['nationality'])?></p>
                <p>Religion : <?php echo htmlspecialchars($employee_detail['religion'])?></p>
                <p>Postal Code : NULL</p>
                </div>
                <div class="right-details">
                <p>Driving Liscence Number : <?php echo htmlspecialchars($employee_detail['dl_number'])?></p>
                <p>Employment Type : <?php echo htmlspecialchars($employee_detail['employement_type'])?></p>
                <p>Qualifications : <?php echo htmlspecialchars($employee_detail['qualifications'])?></p>
                <p>Specialization : <?php echo htmlspecialchars($employee_detail['specialization'])?></p>
                <p>Department : <?php echo htmlspecialchars($employee_detail['department'])?></p>
                <p>Position : <?php echo htmlspecialchars($employee_detail['position'])?></p>
                <p>Salary/Yr : <?php echo htmlspecialchars($employee_detail['salary'])?></p>
                </div>
            </div>
          </div>
       </div>
    </section>
</body>
</html>