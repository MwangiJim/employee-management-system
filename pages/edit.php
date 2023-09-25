<?php
include '../config/clients_db.inc.php';

$name =$email=$phone=$address='';
$id = '';
if(isset($_POST['update-detail'])){
    $id = $_POST['id-to-edit'];
}
$sql = "SELECT * FROM employees WHERE id= '$id'";
$res = mysqli_query($conn,$sql);
$employee_info = mysqli_fetch_assoc($res);
 // echo $id;
  if(isset($_POST['submit-update'])){
    //echo $id;
          $email = $_POST['email'];
          $phone = $_POST['phone'];
          $address = $_POST['address'];
          $name = $_POST['name'];
          $nickname = $_POST['nickname'];
          $gender = $_POST['gender'];
          $date = $_POST['date'];
          $place_of_birth = $_POST['place-of-birth'];
          $status = $_POST['status'];
          $id_number =  $_POST['id-number'];
          $passport_date = $_POST['passport-date'];
          $nationality = $_POST['nationality'];
          $postal_code = $_POST['postal-code'];
          $religion = $_POST['religion'];
          $dl_number = $_POST['DL_Number'];
          $employement = $_POST['employement'];
          $qualifications = $_POST['qualifications'];
          $specialization = $_POST['specialization'];
          $department = $_POST['department'];
          $position = $_POST['position'];
          $salary = $_POST['salary'];
           //use mysqli_real_escape_string to avoid SQL iNJECTIONS along with Prepared Stmts
           $email = mysqli_real_escape_string($conn,$email);
           $phone = mysqli_real_escape_string($conn,$phone);
           $address = mysqli_real_escape_string($conn,$address);
           $name = mysqli_real_escape_string($conn,$name);
           $nickname = mysqli_real_escape_string($conn,$nickname);
           $gender = mysqli_real_escape_string($conn,$gender);
           $date = mysqli_real_escape_string($conn,$date);
           $place_of_birth = mysqli_real_escape_string($conn,$place_of_birth);
           $status = mysqli_real_escape_string($conn,$status);
           $id_number = mysqli_real_escape_string($conn,$id_number);
           $passport_date = mysqli_real_escape_string($conn,$passport_date);
           $nationality = mysqli_real_escape_string($conn,$nationality);
           $postal_code = mysqli_real_escape_string($conn,$postal_code);
           $religion = mysqli_real_escape_string($conn,$religion);
           $dl_number = mysqli_real_escape_string($conn,$dl_number);
           $employement = mysqli_real_escape_string($conn,$employement);
           $qualifications = mysqli_real_escape_string($conn,$qualifications);
           $specialization = mysqli_real_escape_string($conn,$specialization);
           $department = mysqli_real_escape_string($conn,$department);
           $position = mysqli_real_escape_string($conn,$position);
           $salary = mysqli_real_escape_string($conn,$salary);
  
          $file_update = $_FILES['file'];
          //get file details
          $fileName = $file_update['name'];
          $fileType = $file_update['type'];
          $fileTmpName = $file_update['tmp_name'];
          $fileSize = $file_update['size'];
          $fileError = $file_update['error'];
          //obtain file Extension
          $fileExt = explode('.',$fileName);
          $fileActualExt = strtolower(end($fileExt));
          //setup a container with allowed extensions
           $allowedExts = array('png','jpeg','jpg');
           if(in_array($fileActualExt,$allowedExts)){
               if($fileError === 0){
                   if($fileSize < 200000){
                       $fileActualName = "profile_image" . "." . uniqid("",true) . "." . $fileActualExt;
                       $fileDestination = "../avatar_img/gallery/" . $fileActualName;
  
                       $sql_query = "UPDATE employees SET name='$name',nickname='$nickname',profile_img_path='$fileDestination',email='$email',phonenumber='$phone',address='$address',
                       gender='$gender',date_of_birth='$date',place_of_birth='$place_of_birth',marriage_status='$status',id_number=$id_number,passport_expiry_date='$passport_date',
                       nationality='$nationality',religion='$religion',dl_number='$dl_number',employement_type='$employement',qualifications='$qualifications',specialization='$specialization',
                       department='$department',position='$position',salary='$salary' WHERE id = '$id'";
                       if(mysqli_query($conn,$sql_query)){
                        move_uploaded_file($fileTmpName,$fileDestination);
                        header('Location:./index.php?updateProfile=Success');
                        exit();
                       }
                       else{
                        header('Location:./edit.php?error=updateFailed');
                        echo mysqli_error($conn);
                        exit();
                       }
                   }else{
                      header('Location:./edit.php?error=FileSizeExceededLimit');
                      exit();
                   }
               }else{
                  header('Location:./edit.php?error=FileCorrupted');
                  exit();
               }
           }else{
              header('Location:./edit.php?error=FileExtensionNotAllowed&&AllowedExts={png,jpeg,jpg}');
              exit();
           }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../styles.css"/>
    <style>
           .head{
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 12px;
        background-color: #fff;
     }
     .info-box{
        background-color: #fff;
        border-radius: 6px;
        margin-top: 10px;
        padding: 10px;
     }
     .add-clients-form{
        width: 100%;
        height: 100vh;
        top:0;
        left: 0;
        position: absolute;
        background-color: #d3d3d3;
     }
     .titles{
        display: flex;
        justify-content: left;
        align-items:center;
        margin-top: 10px;
     }
     .info-box span{
        height: 20px;
        width: 4px;
        background-color: #000;
        display: block;
        margin: 0px 5px;
     }
     .personal-info{
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 15px 0;
     }
     .personal-info input{
        width:350px;
        border: 1px solid #000;
        outline: none;
        padding: 0 10px;
        height: 40px;
        border-radius: 6px;
     }
     .contact-info{
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 15px 0;
     }
     .contact-info input{
        width:350px;
        border: 1px solid #000;
        outline: none;
        padding: 0 10px;
        height: 40px;
        border-radius: 6px;
     }
     .cv{
        display: grid;
        grid-template-columns: repeat(3,465px);
     }
     .input-area{
        width:400px;
        text-align: left;
        margin: 15px 0;
     }
     .input-area input{
        width:370px;
        border: 1px solid #000;
        outline: none;
        padding: 0 15px;
        height: 40px;
        border-radius: 6px;
     }
     .input-area select{
        width:400px;
        border: 1px solid #000;
        outline: none;
        padding: 0 10px;
        height: 40px;
        border-radius: 6px;
     }
     .input-area h5{
        margin: 5px 0;
     }
     .jobs-area{
        display: grid;
        grid-template-columns: repeat(3,450px);
     }
     .job-box{
        width:400px;
        margin: 10px 0;
     }
     .job-box h5{
        margin: 5px 0;
     }
     .job-box select{
        width:400px;
        border: 1px solid #000;
        outline: none;
        padding: 0 10px;
        height: 40px;
        border-radius: 6px;
     }
     form button{
        background-color: #4315e9;
        width: 100%;
        border: none;
        padding:12px 40px;
        outline: none;
        border-radius: 10px;
        color: #fdfdfd;
        cursor: pointer;
     }
    </style>
</head>
<body>
<section class="add-clients-form">
    <div class="head">
       <h1>ADMIN</h1> 
    </div>
        <div class="info-box">
        <h4>Edit User Details</h4>
        <form action="./edit.php" method="POST" enctype="multipart/form-data">
            <div class="titles">
                <span></span>
                <h4>Personal Information</h4>
            </div>
           <div class="personal-info">
                <input class="input" name="name" type="text" placeholder="Client Name" value='<?php echo htmlspecialchars($employee_info['name']) ?>'/>
                <input class="input" name="nickname" type="text" placeholder="Username" value="<?php echo htmlspecialchars($employee_info['nickname'])?>" />
                <div class="profile_img">
                    <h5>Profile Avatar</h5>
                    <input name="file" type="file"/>
                </div>
           </div>
           <div class="titles">
                <span></span>
                <h4>Personal Information</h4>
            </div>
           <div class="contact-info">
            <input name="email" type="email" placeholder="Email Address" value='<?php echo htmlspecialchars($employee_info['email']) ?>'/>
            <input name="phone" type="number" placeholder="Phone Number" value='<?php echo htmlspecialchars($employee_info['phonenumber']) ?>'/>
            <input name="address" type="text" placeholder="Address Location" value='<?php echo htmlspecialchars($employee_info['address']) ?>'/>
           </div>
           <div class="titles">
                <span></span>
                <h4>Curriculum Vitae</h4>
            </div>
            <div class="cv">
                <div class="input-area">
                    <h5>Sex</h5>
                <select name="gender">
                <option>---Choice---</option>
                    <option value="male">Male</option>
                    <option value="male">Female</option>
                    <option value="male">Prefer Not To Say</option>
                </select>
                </div>
                <div class="input-area">
                    <h5>Date Of Birth</h5>
                    <input type="date" name="date" value="<?php echo htmlspecialchars($employee_info['date_of_birth'])?>"/>
                </div>
                <div class="input-area">
                    <h5>Place of Birth</h5>
                    <input type="text" name="place-of-birth" value="<?php echo htmlspecialchars($employee_info['place_of_birth'])?>"/>
                </div>
                <div class="input-area">
                    <h5>Marriage Status</h5>
                    <select name="status">
                        <option>---Choice---</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                    </select>
                </div>
                <div class="input-area">
                    <h5>ID Number</h5>
                    <input type="text" name="id-number" value="<?php echo htmlspecialchars($employee_info['id_number'])?>"/>
                </div>
                <div class="input-area">
                    <h5>Passport Expiry Date</h5>
                    <input type="date" name="passport-date" value="<?php echo htmlspecialchars($employee_info['passport_expiry_date'])?>"/>
                </div>
                <div class="input-area">
                    <h5>Nationality</h5>
                    <input type="text" name="nationality" value="<?php echo htmlspecialchars($employee_info['nationality'])?>"/>
                </div>
                <div class="input-area">
                    <h5>Postal Code</h5>
                    <input type="text" name="postal-code"/>
                </div>
                <div class="input-area">
                    <h5>Religion</h5>
                    <input type="text" name="religion" value="<?php echo htmlspecialchars($employee_info['religion'])?>"/>
                </div>
                <div class="input-area">
                    <h5>DL Number</h5>
                    <input type="text" name="DL_Number" value="<?php echo htmlspecialchars($employee_info['dl_number']) ?>"/>
                </div>
            </div>
            <div class="titles">
                <span></span>
                <h4>Job Information</h4>
            </div>
                <div class="jobs-area">
                    <div class="job-box">
                        <h5>Employment Type</h5>
                        <select name="employement">
                            <option>---Choice---</option>
                            <option value="Full Time">Full Time</option>
                            <option value="Part Time">Part Time</option>
                            <option value="Contract">Contract</option>
                            <option value="Intern">Intern</option>
                        </select>
                    </div>
                    <div class="job-box">
                      <h5>Qualifications</h5>
                      <select name="qualifications">
                      <option>---Choice---</option>
                        <option value="PHD">PHD</option>
                        <option value="Bachelors Degree">Degree</option>
                        <option value="High School">High School</option>
                      </select>
                    </div>
                    <div class="job-box">
                      <h5>Specialize</h5>
                      <select name="specialization">
                      <option>---Choice---</option>
                        <option value="Front End Development">Front End Development</option>
                        <option value="Back end Development">Back end Development</option>
                        <option value="Android Development">Android Development</option>
                        <option value="QA Developer">QA Developer</option>
                        <option value="Lead PHP developer">Lead PHP Developer</option>
                        <option value="Lead Node Developer">Lead Node Developer</option>
                      </select>
                    </div>
                    <div class="job-box">
                      <h5>Department</h5>
                      <select name="department">
                      <option>---Choice---</option>
                        <option value="Production">Production</option>
                        <option value="Standards">Standards</option>
                        <option value="Marketing">Marketing</option>
                        <option value="System Analysis">System Analysis</option>
                        <option value="Development Team">Development Team</option>
                        <option value="Marketing Analysis">Marketing Analysis</option>
                      </select>
                    </div>
                    <div class="job-box">
                      <h5>Position</h5>
                      <select name="position">
                      <option>---Choice---</option>
                        <option value="Senior Front End Development">Senior Front End Development</option>
                        <option value="Junior Back end Development"> Junior Back end Development</option>
                        <option value="Intern Android Development">Intern Android Development</option>
                        <option value="Lead QA Developer">Lead QA Developer</option>
                        <option value="Junior PHP developer">Junior PHP Developer</option>
                        <option value="Lead Node Developer">Lead Node Developer</option>
                      </select>
                    </div>
                    <div class="job-box">
                      <h5>Salary/year[$/year]</h5>
                      <select name="salary">
                      <option>---Choice---</option>
                        <option value="$20000-$35000">$20000-$35000</option>
                        <option value="$40000-$45000">$40000-$45000</option>
                        <option value="$47700-$55000">$47700-$55000</option>
                        <option value="$60000-$70000">$60000-$70000</option>
                        <option value="$70000-$79500">$70000-$79500</option>
                        <option value="$80000 and Above">$80000 and Above</option>
                      </select>
                    </div>
                </div>
           <button type="submit" name="submit-update">Edit User</button>
           <a href="./index.php">Cancel</a>
        </form>
        </div>
    </section>
</body>
</html>