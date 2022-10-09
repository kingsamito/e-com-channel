<div class="noScreen">
            <div>
                <img src="img/main.png" width="105" height="145" style="margin-top: 50px;">
            </div>
            <div>
                <b>
                    <p>CRAWFORD UNIVERSITY</p>
                    <p>FAITH CITY, IGBESA, OGUN STATE.</p>
                </b>
            </div>
        </div>
        <div class="noprint">
            <?php
            if ($member == 'student') {
            ?>
                <a href="studentdashboard.php?folder=inbox"><button class="">&larr;</button></a>
            <?php
            } elseif ($member == 'academic_staff') {
            ?>
                <a href="academic_staffdashboard.php?folder=inbox"><button class="">&larr;</button></a>
            <?php
            } elseif ($member == 'management') {
            ?>
                <a href="managementdashboard.php?folder=inbox"><button class="">&larr;</button></a>
            <?php
            } else {
            ?>
                <a href="non_academic_staffdashboard.php?folder=inbox"><button class="">&larr;</button></a>
            <?php
            }
            ?>
        </div>