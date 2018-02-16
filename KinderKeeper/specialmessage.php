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

$tempKIND = $_GET['kind'];
$tempID = $_GET['id'];
$query = "SELECT * FROM 239_kidlist_table WHERE '$tempID' = kid_id";  
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_array($result);
mysqli_free_result($result);

if (isset($_POST['submit'])) {
    $message = $_POST['personalMessage'];
    $time = $_POST['time'];
    $date = $_POST['date'];
    $query ="INSERT INTO 239_kid_events (kid_id, message, date, time, kind)
            VALUES ('$tempID', '$message', '$date', '$time', '$tempKIND')";
    mysqli_query($connection, $query);
    header('LOCATION: eventlist.php?id=' . $tempID . '&kind=' . $tempKIND);
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>KinderKeeper - הודעה מותאמת אישית</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="includes/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Alef" rel="stylesheet">
    <script src="includes/js/jquery-3.2.1.min.js"></script>
    <script src="includes/js/main.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="shortcut icon" href="images/minilogo.ico" />
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
        <section>
        <?php
            $tempID = $_GET['id'];
            $_SESSION['kid_id'] = $tempID;
            $query = "SELECT * FROM 239_kidlist_table WHERE '$tempID' = kid_id";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_array($result);
            mysqli_free_result($result);
        ?>

            <img src="images/kid<?php echo $row['kid_id']; ?>.png" alt="<?php echo $row['kid_name']; ?>"> </img>
            <h5><?php echo $row['kid_name']; ?></h5>
        </section>
        <nav>
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
        <section id="specialMessage">
            <h5 class="underline">הודעה מותאמת אישית </h5>
            <form method="post">
                <h5>:פרטי האירוע</h5><textarea rows="10" cols="31" placeholder="0/500" name="personalMessage" dir="rtl" required></textarea>
                <h5>:תאריך</h5><input type="date" name="date" required><br>
                <h5>:שעה</h5><input type="time" name="time" required><br>
                <input class="ui-button ui-widget ui-corner-all" type="submit" value="הוסף אירוע" name="submit">
                <br><br><br>
            </form>
        </section>
    </main>
    <footer>
     <nav>
        <ul>
            <li>
                <a href="#" id="deleteFooter"></a>
            </li>
            <li>
                <a href="#" id="searchFooter"></a>
            </li>
            <li>
                <a href="#" id="addFooter"></a>
            </li>
        </ul>
      </nav>
    </footer>
</body>

</html>
<?php mysqli_close($connection);?>