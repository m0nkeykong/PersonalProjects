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
  $query = "SELECT * FROM 239_kidlist_table WHERE '$tempID' = kid_id";  
  $result = mysqli_query($connection, $query);
  $row = mysqli_fetch_array($result);
  mysqli_free_result($result);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>KinderKeeper - קינדרקיפר</title>
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
        <img src="images/kid<?php echo $row['kid_id'];?>.png" alt="<?php echo $row['kid_name']; ?>"> </img>
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
                        <a href="#">הערות</a>
                    </h6>
                </li>
            </ul>
        </nav>
        <section id="Obehave">
            <h5 class="underline"> הגעה </h5>
            <article id="recTL">
                <a href="arrival-pickup.php?msg=אתעכב בכמה דקות" class="pau"> אתעכב בכמה דקות </a>
            </article>
            <article id="recTR">
                <a href="changePick.php" class="pau"> שינוי אוסף </a>
            </article>
            <article id="recBL">
                <a href="arrpick-msg.php" class="pau"> הזן הודעה אישית </a>
            </article>
            <article id="recBR">
                <a href="arrival-pickup.php?msg=<?php echo $_SESSION['user_name'];?> ביטול אוסף אחר "class="pau"> ביטול שינוי אוסף </a>
            </article>
        </section>
        <div class="clear"></div>
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