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
  
  $tempID = $_GET['id'];
  $tempKIND = $_GET['kind'];
  $query = "SELECT * FROM 239_kidlist_table WHERE '$tempID' = kid_id";  
  $result = mysqli_query($connection, $query);
  $row = mysqli_fetch_array($result);
  mysqli_free_result($result);

    if (isset($_POST['submit'])) {
        $message = $_POST['eventlist'];
        $Hours = date("G");
        $Hours = $Hours + 2;
        if ($Hours > 23)
        $Hours = $Hours - 24;
        $time = $Hours . date(":i");
        $date = date("d/m/Y");

        $query ="INSERT INTO 239_kid_events (kid_id, message, date, time, kind)
                 VALUES ('$tempID', '$message', '$date', '$time', '$tempKIND')";
        mysqli_query($connection, $query);
        header('LOCATION: eventlist.php?id=' . $tempID . '&kind=2');
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>KinderKeeper - הוספת אירוע</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="includes/style.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css?family=Alef" rel="stylesheet">
    <script src="includes/js/jquery-3.2.1.min.js"></script>
    <script src="includes/js/main.js"></script>
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
        <section id="chooseEvent3">
            <h5 class="underline"> בחר\י את האירוע שברצונך להוסיף </h5>
            <form method="post">
                <label class="container">
                    <a href="specialmessage.php?id=<?php echo $row['kid_id'];?>&kind=2" target="_self">הזן הודעה מותאמת אישית</a>
                    <input type="radio" name="eventlist" disabled>
                    <span class="checkmark"></span>
                </label>
                <div>
                    <input class="ui-button ui-widget ui-corner-all" type="submit" name="submit" value="הוסף אירוע">
                </div>
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