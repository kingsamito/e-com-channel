<?php

include_once '../conn.php';

if ($_POST['from'] == 'admin-profile') {


    $id = $_POST['id_data'];
    $sql = "SELECT * FROM `admin` WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row1 = mysqli_fetch_assoc($result);
        $firstname = $row1['firstname'];
        $lastname = $row1['lastname'];
        $username = $row1['username'];
    }

    $lnameErr = $fnameErr = $usernameErr = '';
    $output = '<div class="modal-body" id="editresult"><input type="hidden" name="id" value="' . $id . '"><div class="form-group"><label> Firstname </label><input type="text" name="fname" class="form-control" value="' . $firstname . '" placeholder="Enter firstname"><p style="color: #ff3333;">' . $fnameErr . '</p></div><div class="form-group"><label> Lastname </label><input type="text" name="lname" class="form-control" value="' . $lastname . '" placeholder="Enter lastname"><p style="color: #ff3333;">' . $lnameErr . '</p></div><div class="form-group"><label> Username </label><input type="text" name="username" class="form-control" value="' . $username . '" placeholder="Enter Username"><p style="color: #ff3333;">' . $usernameErr . '</p></div></div>';


    echo $output;
} elseif (preg_match("/user=management/i", $_POST['from'])) {
    $id = $_POST['id_data'];
    $sql = "SELECT * FROM `management` WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row1 = mysqli_fetch_assoc($result);
        $firstname = $row1['Firstname'];
        $lastname = $row1['Lastname'];
        $position = $row1['Position'];
        $position_short = $row1['Position_short'];
        $email = $row1['Email'];
        $tel = $row1['Phone'];
        
    }

    $lnameErr = $fnameErr = $positionErr = $emailErr = $telErr = '';
    $output = '<div class="modal-body" id="editresult"><input type="hidden" name="id" value="' . $id . '"><div class="form-group">
    <label for="lname">Lastname:</label>
    <input type="text" class="form-control" id="lname" name="lname" value="' . $lastname . '"><span><?php echo $lnameErr; ?></span>
</div>
<div class="form-group">
    <label for="fname">Firstname:</label>
    <input type="text" class="form-control" id="fname" name="fname" value="' . $firstname . '"><span><?php echo $fnameErr; ?></span>
</div>
<div class="form-group">
    <label for="position">Position:</label>
    <input type="text" class="form-control" id="position" name="position" value="' . $position . '"><span><?php echo $positionErr; ?></span>
</div>
<div class="form-group">
    <label for="position">Position_short:</label>
    <input type="text" class="form-control" id="position_short" name="position_short" value="' . $position_short . '"><span></span>
</div>
<div class="form-group">
    <label for="email">Email:</label>
    <input type="email" class="form-control" id="email" name="email" value="' . $email . '"><span><?php echo $emailErr; ?></span>
</div>
<div class="form-group">
    <label for="tel">Phone Number:</label>
    <input type="text" class="form-control" id="tel" name="tel" value="' . $tel . '"><span><?php echo $telErr; ?></span>
</div></div>';


    echo $output;

}elseif (preg_match("/user=academic_staff/i", $_POST['from'])) {
    $id = $_POST['id_data'];
    $sql = "SELECT * FROM `academic_staff` WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row1 = mysqli_fetch_assoc($result);
        $firstname = $row1['Firstname'];
        $lastname = $row1['Lastname'];
        $position = $row1['Position'];
        $email = $row1['email'];
        
    }

    $lnameErr = $fnameErr = $positionErr = $emailErr = '';
    $output = '<div class="modal-body" id="editresult"><input type="hidden" name="id" value="' . $id . '"><div class="form-group">
    <label for="lname">Lastname:</label>
    <input type="text" class="form-control" id="lname" name="lname" value="' . $lastname . '"><span><?php echo $lnameErr; ?></span>
</div>
<div class="form-group">
    <label for="fname">Firstname:</label>
    <input type="text" class="form-control" id="fname" name="fname" value="' . $firstname . '"><span><?php echo $fnameErr; ?></span>
</div>
<div class="form-group">
    <label for="position">Position:</label>
    <input type="text" class="form-control" id="position" name="position" value="' . $position . '"><span><?php echo $positionErr; ?></span>
</div>
<div class="form-group">
    <label for="email">Email:</label>
    <input type="email" class="form-control" id="email" name="email" value="' . $email . '"><span><?php echo $emailErr; ?></span>
</div></div>';


    echo $output;

}elseif (preg_match("/user=non_academic_staff/i", $_POST['from'])) {
    $id = $_POST['id_data'];
    $sql = "SELECT * FROM `non_academic_staff` WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row1 = mysqli_fetch_assoc($result);
        $firstname = $row1['Firstname'];
        $lastname = $row1['Lastname'];
        $position = $row1['Position'];
        $email = $row1['Email'];
        $tel = $row1['Phone'];
        
    }

    $lnameErr = $fnameErr = $positionErr = $emailErr = $telErr = '';
    $output = '<div class="modal-body" id="editresult"><input type="hidden" name="id" value="' . $id . '"><div class="form-group">
    <label for="lname">Lastname:</label>
    <input type="text" class="form-control" id="lname" name="lname" value="' . $lastname . '"><span><?php echo $lnameErr; ?></span>
</div>
<div class="form-group">
    <label for="fname">Firstname:</label>
    <input type="text" class="form-control" id="fname" name="fname" value="' . $firstname . '"><span><?php echo $fnameErr; ?></span>
</div>
<div class="form-group">
    <label for="position">Position:</label>
    <input type="text" class="form-control" id="position" name="position" value="' . $position . '"><span><?php echo $positionErr; ?></span>
</div>
<div class="form-group">
    <label for="email">Email:</label>
    <input type="email" class="form-control" id="email" name="email" value="' . $email . '"><span><?php echo $emailErr; ?></span>
</div>
<div class="form-group">
    <label for="tel">Phone Number:</label>
    <input type="text" class="form-control" id="tel" name="tel" value="' . $tel . '"><span><?php echo $telErr; ?></span>
</div></div>';


    echo $output;

}elseif (preg_match("/user=student/i", $_POST['from'])) {
    $id = $_POST['id_data'];
    $sql = "SELECT * FROM `student` WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row1 = mysqli_fetch_assoc($result);
        $firstname = $row1['Firstname'];
        $lastname = $row1['Lastname'];
        $position = $row1['Position'];
        $email = $row1['email'];
        
        
    }

    $lnameErr = $fnameErr = $positionErr = $emailErr = '';
    $output = '<div class="modal-body" id="editresult"><input type="hidden" name="id" value="' . $id . '"><div class="form-group">
    <label for="lname">Lastname:</label>
    <input type="text" class="form-control" id="lname" name="lname" value="' . $lastname . '"><span><?php echo $lnameErr; ?></span>
</div>
<div class="form-group">
    <label for="fname">Firstname:</label>
    <input type="text" class="form-control" id="fname" name="fname" value="' . $firstname . '"><span><?php echo $fnameErr; ?></span>
</div>
<div class="form-group">
    <label for="position">Position:</label>
    <input type="text" class="form-control" id="position" name="position" value="' . $position . '"><span><?php echo $positionErr; ?></span>
</div>
<div class="form-group">
    <label for="email">Email:</label>
    <input type="email" class="form-control" id="email" name="email" value="' . $email . '"><span><?php echo $emailErr; ?></span>
</div>
</div>';


    echo $output;

}
else{
    $output = "Invalid";
    echo $output;
}
