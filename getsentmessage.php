

<div class="mb-4 px-3">

    <div class="message">

        <?php

        if (mysqli_num_rows($sentresult) > 0) {
            while ($sentrow = mysqli_fetch_assoc($sentresult)) {
                $sentrow['date'] = strtotime($sentrow['date']);
                if ($sentrow['date'] >= strtotime("today")) {
                    $sentrow['date'] = date("h:ia", $sentrow['date']);
                } elseif ($sentrow['date'] >= strtotime("yesterday")) {
                    $sentrow['date'] = "yesterday";
                } elseif ($sentrow['date'] >= strtotime("-2 Days")) {
                    $sentrow['date'] = date("l", $sentrow['date']);
                }elseif ($sentrow['date'] >= strtotime("-3 Days")) {
                    $sentrow['date'] = date("l", $sentrow['date']);
                }elseif ($sentrow['date'] >= strtotime("-4 Days")) {
                    $sentrow['date'] = date("l", $sentrow['date']);
                }elseif ($sentrow['date'] >= strtotime("-5 Days")) {
                    $sentrow['date'] = date("l", $sentrow['date']);
                }else{
                    $sentrow['date'] = date("m/d/y", $sentrow['date']);
                }
                if ($sentrow['type'] == 'memo') {
                    ?>

                        <div class="card">
                            <a href="memosentopener.php?id=<?php echo $sentrow['id']; ?>" class="list-group-item-action stretched-link">
                                <div class="card-body p-3">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><?php echo $sentrow['receiver']; ?></div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-600"><?php echo $sentrow['subject']; ?></div>
                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-600"><?php echo $sentrow['date']; ?></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php
                    } elseif ($sentrow['type'] == 'forwarded_memo') {
                    ?>

                        <div class="card">
                            <a href="forwarded_memo_sent.php?id=<?php echo $sentrow['id']; ?>" class="list-group-item-action stretched-link">
                                <div class="card-body p-3">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><?php echo $sentrow['receiver']; ?></div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-600"><?php echo $sentrow['subject']; ?></div>
                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-600"><?php echo $sentrow['date']; ?></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php
                    }else {
                    ?>

                        <div class="card">
                            <a href="commented_academic_letter_sent_opener.php?id=<?php echo $sentrow['id']; ?>" class="list-group-item-action stretched-link">
                                <div class="card-body p-3">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><?php echo $sentrow['receiver']; ?></div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-600"><?php echo $sentrow['subject']; ?></div>
                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-600"><?php echo $sentrow['date']; ?></div>
                                    </div>
                                </div>
                            </a>
                        </div>
        <?php
                    }
                
            
               }  } else {
            echo "No Message";
        }
        ?>
    </div>
</div>