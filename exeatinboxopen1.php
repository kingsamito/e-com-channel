<?php 
include_once 'conn.php';

session_start();

if(!isset($_SESSION["Position"])){
    header("Location: login.php");
  } 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memo</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    
    <script src="jquery.min.js"></script>
    <script src="popper.min.js"></script>
    <script src="bootstrap.min.js"></script>
    
</head>
<body>
    
    <a href="dashboard.php"><button class="btn btn-primary">Go Back</button></a>
    
    <div class="container">
        <?php

            $id = $_GET['id'];
            $sql = "SELECT * FROM exeat_inbox WHERE id=$id";
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)){
                $row=mysqli_fetch_assoc($result);
  
            }
              $sender = $row['sender'];
              $matric = $row['matric'];
              $to = $row['too'];
              $through = $row['through'];
              $block = $row['block'];
              $room = $row['room'];
              $hostel = $row['hostel'];
              $subject = $row['subject'];
              $message = $row['message'];
              $parent = $row['parentnumber'];
              $date = $row['date'];
              $hm_comment = $row['hm_comment'];
              $dsa_comment = $row['dsa_comment'];

              
              $query = "SELECT * FROM non_academic_staff WHERE Position = 'Hall Master'";
              $queryres = mysqli_query($conn,$query);
              if(mysqli_num_rows($queryres)){
                $row=mysqli_fetch_assoc($queryres);
                $name = $row['Lastname']." ".$row['Firstname'];
  
            }
              $query1 = "SELECT * FROM non_academic_staff WHERE Position = 'Chief Medical Director'";
              $queryres1 = mysqli_query($conn,$query1);
              if(mysqli_num_rows($queryres1)){
                $row1=mysqli_fetch_assoc($queryres1);
                $name1 = $row1['Lastname']." ".$row1['Firstname'];
  
            }
              $query2 = "SELECT * FROM non_academic_staff WHERE Position = 'Dean Student Affairs'";
              $queryres2 = mysqli_query($conn,$query2);
              if(mysqli_num_rows($queryres2)){
                $row2=mysqli_fetch_assoc($queryres2);
                $name2 = $row2['Lastname']." ".$row2['Firstname'];
  
            }
          
        ?>
        <div class="clearfix">
            <div class="float-right">
            <h4><?php echo "Room ". $room.", ".$block." block,"; ?></h4>
            <h4><?php echo $hostel." hostel,"; ?></h4>
            <h4>Crawford University,</h4>
            <h4>Ogun State.</h4>
                
                <h4><?php echo $date."."; ?></h4>
            </div>
        </div>
        <h4>To: <?php echo $to; ?></h4>
        <h4>Through: <?php echo $through; ?></h4>
        <h4>Crawford University,</h4>
        <h4>Faith city, Lusada,</h4>
        <h4>Ogun State.</h4>
        
        <h4 class="ml-5">Dear Sir,</h4>
        <div class="text-center">
            <h4><?php echo $subject; ?></h4>
        </div>
        <div>
            <p><?php echo "<b>My name is ".$sender." with matric number ".$matric." </b> ".$message; ?></p>
        </div>
        <div>Parent phone number: <?php echo $parent; ?></div>
    </div>
    <div class="container">
        <?php
        
        
            if($_SESSION['Position'] == 'Dean Student Affairs' && $dsa_comment == ''){
                echo '<form method="post">
                <button class="btn btn-success" type="submit" name="approve">Approve</button>
                <button class="btn btn-danger" type="submit" name="decline">Decline</button>
                
                </form>';
                    if(isset($_POST['approve'])){
                        $dsa_comment = "Approved: ".date("d-m-Y");
                        $sql = "UPDATE exeat_inbox SET dsa_comment='$dsa_comment' WHERE id=$id";
                        $result = mysqli_query($conn,$sql);
                        if($result){
                            $asql = "INSERT INTO student_exeat_inbox(`sender`, `matric`, `too`, `through`, `block`, `room`, `hostel`, `subject`, `message`, `parentnumber`,`hm_comment`,`dsa_comment`) VALUES('$sender', '$matric' , '$to', '$through','$block','$room','$hostel','$subject','$message','$parent','$hm_comment','$dsa_comment')";
                            $aresult = mysqli_query($conn,$asql);
                            header("Location: exeatinboxopen.php?id=$id");
                        }
/*                         $aasql = "INSERT INTO adminapprove(`sender`, `matric`, `too`, `through`, `block`, `room`, `hostel`, `subject`, `message`, `parentnumber`,`hm_comment`,`dsa_comment`) VALUES('$sender', '$matric' , '$to', '$through','$block','$room','$hostel','$subject','$message','$parent','$hm_comment','$dsa_comment')";
 */                        
/*                         $aaresult = mysqli_query($conn,$aasql);
 */                        
                        
                    }
                    if(isset($_POST['decline'])){
                        $dsa_comment = "Declined: ".date("d-m-Y");
                        $sql = "UPDATE exeat_inbox SET dsa_comment='$dsa_comment' WHERE id=$id";
                        $result = mysqli_query($conn,$sql);
                        if($result){
                            $dsql = "INSERT INTO student_exeat_inbox(`sender`, `matric`, `too`, `through`, `block`, `room`, `hostel`, `subject`, `message`, `parentnumber`,`hm_comment`,`dsa_comment`) VALUES('$sender', '$matric' , '$to', '$through','$block','$room','$hostel','$subject','$message','$parent','$hm_comment','$dsa_comment')";
                            $dresult = mysqli_query($conn,$dsql);
                            header("Location: exeatinboxopen.php?id=$id");
                        }
                    }
            }else{
                $dsa_comment = $dsa_comment;
                } 

        
           if($_SESSION['Position'] == 'Hall Master' || $_SESSION['Position'] == 'Chief Medical Director' && $hm_comment == ''){
                echo '<form method="post">
                <button class="btn btn-success" type="submit" name="approve">Approve</button>
                <button class="btn btn-danger" type="submit" name="decline">Decline</button>
                
                </form>';
                    if(isset($_POST['approve'])){
                        $hm_comment = "Approved: ".date("d-m-Y");
                        $sql = "UPDATE exeat_inbox SET hm_comment='$hm_comment' WHERE id=$id";
                        $result = mysqli_query($conn,$sql);
                        
                        header("Location: exeatinboxopen.php?id=$id");
                        
                    }
                    if(isset($_POST['decline'])){
                        $hm_comment = "Declined: ".date("d-m-Y");
                        $sql = "UPDATE exeat_inbox SET hm_comment='$hm_comment' WHERE id=$id";
                        $result = mysqli_query($conn,$sql);
                        header("Location: exeatinboxopen.php?id=$id");
                    }
            }else{
                $hm_comment = $hm_comment;
                }
        
    
        
        ?>
        <div class="row">
         <div class="col">
             <?php
             if($_SESSION['Position'] == 'Hall Master'){
                 echo "<h6>".$name."<br>".$through."<br>".$hm_comment."</h6>";
             }
             if($_SESSION['Position'] == 'Chief Medical Director'){
                 echo "<h6>".$name1."<br>".$through."<br>".$hm_comment."</h6>";
             }
             ?>
       </div>
       <div class="col">
       <?php
                 echo "<h6>".$name2."<br>".$to."<br>".$dsa_comment."</h6>";
             ?>
       </div>
       
   </div>
    </div>
</body>
</html>