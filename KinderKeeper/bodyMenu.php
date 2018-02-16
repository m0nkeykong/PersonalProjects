        <nav id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" id="triggerClose"></a>
            <a href="#" id="settings"></a>
            <a href="#" id="userPhoto"></a>
        
            <article id="centerMenu">
                <h4><?php echo $_SESSION['user_name'];?></h4>
                <h6><?php echo $_SESSION['role'];?>, <?php echo $_SESSION['garden_name'];?></h6>
            </article>

            <ul>
                <li class="arrival">
                    <a href="arrival-pickup.php">הגעה / איסוף</a>
                </li>
                <li class="bulitingBoard">
                    <a href="index.php">לוח מודעות</a>
                </li>
                <li class="personalRecord">
                    <a href="kidslist.php">מעקב אישי</a>
                </li>
                <li class="phoneBook">
                    <a href="#">ספר טלפונים</a>
                </li>
                <li class="liveStream">
                    <a href="#">צפייה בשידור חי</a>
                </li>
                <li class="gallery">
                    <a href="#">גלריית תמונות</a>
                </li>
                <li class="calender">
                    <a href="#">לוח שנה</a>
                </li>
                <li class="aboutUs">
                    <a href="#">פרטי הגן</a>
                </li>
            </ul>
        </nav>
        
        <script type='text/javascript'>
            document.getElementById("userPhoto").style.background = 'url("<?php echo $_SESSION['user_img'];?>") center no-repeat';
        </script>