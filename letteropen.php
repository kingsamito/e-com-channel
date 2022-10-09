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
            $matric = $_SESSION["Matric"];
            $id = $_GET['id'];
            
            $sql = "SELECT * FROM academic_letter_sent WHERE (matric = $matric AND id='$id') UNION SELECT * FROM other_letter_sent WHERE (matric = $matric AND id='$id');";
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
              $date = $row['date'];
              
        
          
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
        <?php $str = explode(";",$through);
        for($i=0; $i<count($str)-1; $i++){
            echo '<h4>Through: '. $str[$i]. '</h4>';
        } ; ?></h4>
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
        
   </div>
    </div>
</body>
</html>