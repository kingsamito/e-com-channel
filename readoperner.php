<?php
    include_once 'conn.php';

    session_start();
    
          $user =$_SESSION['user'];  
                    $tin ="";
                    $comment = "";
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM testmsg WHERE id = '$id'";
                    $result = mysqli_query($conn,$sql);
                    
                    function validate($data){
                        $data = htmlspecialchars($data);
                        $data = stripslashes($data);
                        $data = trim($data);
                        return $data;
                    }

                    $comentErr = '';   
                    if(isset($_POST["submit"])){
                        $coment = mysqli_real_escape_string($conn, $_POST['comment']);
                        
                
                        if(empty($coment)) {
                            $comentErr = "comment is required";
                        }
                        
                        else{
                            $coment = validate($coment);
                    
                            if(!preg_match("/^[a-zA-Z-' ]*$/",$coment)) {
                                $comentErr = "Only letters and white spaces allowed";
                            }
                    
                        }
                       
                    
                    
                        if($comentErr =='') {
                            $add = $user . ": " .$coment. ";";
                            $sql = "UPDATE `testmsg` SET `comment`= CONCAT(comment, '$add') WHERE id = '$id'";
                            $result = mysqli_query($conn,$sql);
                            if($result) {
                                echo "<script>alert('Sent Successfully')</script>";
                                header("Location: reader.php");
                                
                            }
                            else {
                                echo "<script>alert('Message unsuccessfully')</script>";
                            }
                        }
                        
                    
                    
                    }        
                            
            
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    
    <script src="jquery.min.js"></script>
    <script src="popper.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <style>
        body{
            background-image: url('img/marvin-meyer-SYTO3xs06fU-unsplash.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }
        span {
            color:red;
        }
        .body{
            width: 55%;
            margin-top:20px;
            padding: 50px;
            background-color:rgba(0,0,0,.55) ;
            border-radius: 25px;
            color: white;
            
        }
        .nav {
            justify-content: center;
            
        }
        .nav a{
            color: white;
        }
    </style>
</head>
<body>
    <div class="container body"><?php
            echo $user;
        ?>
        <div>

        
        <form method="POST" action="" id="messageform">
        <?php
            if(mysqli_num_rows($result) > 0){
                while($row=mysqli_fetch_assoc($result)){
                    $to = $row['too'];
                    $tin = explode(";",$row['thr']);
                    $comment = $row["comment"];
                     
                }
                $newLen = count($tin) - 1;
                
               if($newLen == 3){
                $search = preg_quote(":");
                $nefind = $tin[2].":";
                $find = "/$nefind/";

                $nefind1 = $tin[1].":";
                $find1 = "/$nefind1/";

                $nefind2 = $tin[0].":";
                $find2 = "/$nefind2/";
                if($user == $tin[2]){
                    $sql = "SELECT * FROM testmsg WHERE id = '$id'";
                    $result = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result) > 0){
                        while($row=mysqli_fetch_assoc($result)){
                            echo $row['msg']."<br>";
                            $tr = explode(";",$row['comment']);
                            foreach($tr as $x => $x_value) {
                                echo $x_value;
                                echo "<br>";
                              }
                            echo '<div>
                            <label>Comment:</label>
                            <input type="text" name="comment" placeholder="comment">
                            <button class="btn btn-success" type="submit" name="submit">Send</button>
                        </div>';
                        }
                    }
                }
                
                elseif($user == $tin[1] && preg_match($find, $comment)){
                    $sql = "SELECT * FROM testmsg WHERE id = '$id'";
                    $result = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result) > 0){
                        while($row=mysqli_fetch_assoc($result)){
                            echo $row['msg']."<br>";
                            $tr = explode(";",$row['comment']);
                            foreach($tr as $x => $x_value) {
                                echo $x_value;
                                echo "<br>";
                              }
                            echo '<div>
                            <label>Comment:</label>
                            <input type="text" name="comment" placeholder="comment">
                            <button class="btn btn-success" type="submit" name="submit">Send</button>
                        </div>';
                        }
                    }
                }

                
                elseif($user == $tin[0] && preg_match($find1, $comment)){
                    $sql = "SELECT * FROM testmsg WHERE id = '$id'";
                    $result = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result) > 0){
                        while($row=mysqli_fetch_assoc($result)){
                            echo $row['msg']."<br>";
                            $tr = explode(";",$row['comment']);
                            foreach($tr as $x => $x_value) {
                                echo $x_value;
                                echo "<br>";
                              }
                            
                            echo '<div>
                            <label>Comment:</label>
                            <input type="text" name="comment" placeholder="comment">
                            <button class="btn btn-success" type="submit" name="submit">Send</button>
                        </div>';
                        }
                    }
                }
                elseif($user == $to && preg_match($find2, $comment)){
                    $sql = "SELECT * FROM testmsg WHERE id = '$id'";
                    $result = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result) > 0){
                        while($row=mysqli_fetch_assoc($result)){
                            echo $row['msg']."<br>";
                            echo $row['comment']."<br>";
                            echo '<div>
                            <label>Comment:</label>
                            <input type="text" name="comment" placeholder="comment">
                            <button class="btn btn-success" type="submit" name="submit">Send</button>
                        </div>';
                        }
                    }
                }
                else{
                    echo "No Message";
                }

               
                
            } 
            }else{
                echo "No Message";
            }
            
        ?>
        </form>
        </div>
    
    </div>

    
</body>
</html>