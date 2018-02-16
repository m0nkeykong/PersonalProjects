<?php
session_start();
define("DBHOST" , "182.50.133.55");
define("DBUSER" , "auxstudDB7c");
define("DBPASS" , "auxstud7cDB1!");
define("DBNAME" , "auxstudDB7c");
$connection = mysqli_connect(DBHOST, DBUSER , DBPASS , DBNAME);
mysqli_query($connection,"SET NAMES 'utf8'") or die(mysql_error());


//testing connection success
if(mysqli_connect_errno()) {
    die("DB connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
}

$parentName = $_SESSION['user_name'];
$query = "SELECT * FROM 239_kid_parent_table 
          INNER JOIN 239_kidlist_table
          WHERE '$parentName' = kid_mother";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_array($result);
$_SESSION['kid_id'] = $row['kid_id'];
mysqli_free_result($result);
if(isset($_GET['msg'])){
    $msg = $_GET['msg'];
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>KinderKeeper - תיק משמעתי</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="includes/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Alef" rel="stylesheet">
    <script src="includes/js/jquery-3.2.1.min.js"></script>
    <script src="includes/js/main.js"></script>
    <link rel="shortcut icon" href="images/minilogo.ico"/>
</head>

<body id="wrapperGlobal">
    <?php
        include("bodyMenu.php")
    ?>    
    <header>
    <?php
        include("headerUserName.php")
    ?>
        <article>
            <h1> מעקב אישי </h1>
        </article>
    </header>
    <main>
        <div id="overlay">
            <div id="text">עדכון בוצע בהצלחה</div>
        </div>
        <section>
            <img src="images/kid<?php echo $row['kid_id']; ?>.png" alt="<?php echo $row['kid_name']; ?>"> </img>
            <h5><?php echo $row['kid_name']; ?></h5>
        </section>
        <nav>
                <?php if(!empty($msg)){echo "<script> document.getElementById('overlay').style.display = 'block';</script>";}?>
            <ul id="submenu">
                <li>
                    <h6>
                        <a href="kid.php?id=<?php echo $row['kid_id']; ?>">פרטים אישיים</a>
                    </h6>
                </li
                ><li id="selected">
                    <h6>
                        <a href="kidrecord.php?id=<?php echo $row['kid_id']; ?>">תיק משמעתי</a>
                    </h6>
                </li
                ><li>
                    <h6>
                        <a href="#">מעקב נוכחות</a>
                    </h6>
                </li
                ><li>
                    <h6>
                        <a href="pieChart.php?id=<?php echo $row['kid_id']; ?>">גרף התפתחות</a>
                    </h6>
                </li>
            </ul>
        </nav>
        <br>
        <br>
        <section id="Obehave">
            <article class="upperRec">
                <a href="arrival.php?id=<?php echo $row['kid_id'];?>"> עדכון הגעה </a>
            </article>
            <article class="lowerRec">
                <a href="pickup.php?id=<?php echo $row['kid_id'];?>"> עדכון איסוף </a>
            </article>
        </section>
    </main>
    <footer>
    </footer>
    <script type="text/javascript">
            document.getElementById("overlay").addEventListener("click", function(){
        document.getElementById("overlay").style.display = "none";
    });
    </script>
</body>

</html>
<?php 
mysqli_close($connection);?>