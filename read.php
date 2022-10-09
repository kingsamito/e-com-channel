<?php
    include_once 'conn.php';

    session_start();
    
    function validate($data){
        $data = htmlspecialchars($data);
        $data = stripslashes($data);
        $data = trim($data);
        return $data;
        }
        $userErr = $passErr = $memberErr = '';  

              
        if(isset($_POST["signin"])) {
            $user = mysqli_real_escape_string($conn, $_POST['login_info']);
            
            
                    
                    $sql = "SELECT * FROM test WHERE user = '$user';";
                    $result = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result) > 0){
                        $row = mysqli_fetch_assoc($result);
                        
                        $_SESSION['user'] = $user;
                        header("Location: reader.php");
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
    <div class="container body">
        <div id="signin" class="tab-pane container show fade active">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> ">
                <div class="form-group">
                    <label class="form-control-label" for="info">Username/user/CRU No.</label>
                    <input id="info" type="text" class="form-control" placeholder="Username/user/CRU No." name="login_info"><span> <?php echo $userErr ?></span>
                </div>
                
                <button type="submit" class="btn btn-success" name="signin">Sign in</button>
            </form>
        </div>
    </div>


</body>
</html>