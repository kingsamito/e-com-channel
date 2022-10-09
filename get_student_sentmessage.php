

<div class="msgs">
    <div class="message">
        <?php
        if (mysqli_num_rows($sentresult) > 0) {
            while ($row = mysqli_fetch_assoc($sentresult)) {
                $row['date'] = strtotime($row['date']);
                if ($row['date'] >= strtotime("today")) {
                    $row['date'] = date("h:ia", $row['date']);
                } elseif ($row['date'] >= strtotime("yesterday")) {
                    $row['date'] = "yesterday";
                } elseif ($row['date'] >= strtotime("-2 Days")) {
                    $row['date'] = date("l", $row['date']);
                }elseif ($row['date'] >= strtotime("-3 Days")) {
                    $row['date'] = date("l", $row['date']);
                }elseif ($row['date'] >= strtotime("-4 Days")) {
                    $row['date'] = date("l", $row['date']);
                }elseif ($row['date'] >= strtotime("-5 Days")) {
                    $row['date'] = date("l", $row['date']);
                }else{
                    $row['date'] = date("m/d/y", $row['date']);
                }
                
                if ($row['type'] == 'exeat' || $row['type'] == 'med_exeat') {
        ?>
                        
                        <div class="card">
                            <a href="exeatopen.php?id=<?php echo $row['id']; ?>" class="list-group-item-action stretched-link">
                                <div class="card-body p-3">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><?php echo $row['too']; ?></div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-600"><?php echo $row['subject']; ?></div>
                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-600"><?php echo $row['date']; ?></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php
                } elseif ($row['type'] == 'others') {
                    ?>

                        <div class="card">
                            <a href="othersopen.php?id=<?php echo $row['id']; ?>" class="list-group-item-action stretched-link">
                                <div class="card-body p-3">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><?php echo $row['too']; ?></div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-600"><?php echo $row['subject']; ?></div>
                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-600"><?php echo $row['date']; ?></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php
                    
                } else {
                    
                    ?>

                        <div class="card">
                            <a href="academicopen.php?id=<?php echo $row['id']; ?>" class="list-group-item-action stretched-link">
                                <div class="card-body p-3">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><?php echo $row['too']; ?></div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-600"><?php echo $row['subject']; ?></div>
                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-600"><?php echo $row['date']; ?></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php
                                      
                   
                }
            }
        }
            
         else {
            echo "No Message";
        }
        ?>


    </div>
</div>