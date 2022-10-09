<?php 
include_once 'conn.php';

session_start();

if(!isset($_SESSION["Position"])){
    header("Location: login.php");
  } 

    $member =  $_SESSION["member"];
    $memberinbox = $member."_inbox";      
  $id = $_GET['id'];
  $sql = "SELECT * FROM  $memberinbox WHERE id=$id";
  $result = mysqli_query($conn,$sql);


  
  if(mysqli_num_rows($result)){
      $row=mysqli_fetch_assoc($result);
    
  }
    $sender = $row['SENDER'];
    $to = $row['RECEIVER'];
    $ref = $row['REF'];
    $date = $row['DATE'];
    $subject = $row['SUBJECT'];
    $message = $row['MESSAGE'];
    $name = $row['NAME'];
   
    


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
    <style>
        .row{
            border-bottom: 2px solid black;
        }
        .row > div:nth-child(2){
            border-left: 2px solid black;
        }
    </style>
</head>
<body>
    
    <a href="dashboard.php"><button class="btn btn-primary">Go Back</button></a>
    
    <div class="container">        

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="from">FROM:</label>
                    <span><?php echo $sender; ?></span>
                </div>
                <div class="form-group">
                    <label for="ref">REF:</label>
                    <span><?php echo $ref; ?></span>
                </div>
                <div class="form-group">
                    <label for="date">DATE:</label>
                    <span><?php echo $date; ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="to">TO:</label>
                    <span><?php echo $to; ?></span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <span><b><?php echo $subject; ?></b></span>
        </div>
        <div class="form-group">
            <span><?php echo $message; ?></span>
        </div>
        <div class="form-group mt-3">
            <span>SIGNATURE</span>
        </div>
        <div class="form-group mt-3">
            <span><?php echo $name; ?></span>
        </div>
    </div>
</body>
</html>