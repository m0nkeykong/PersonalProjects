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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>KinderKeeper - הוספת אירוע</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="includes/style.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Alef' rel='stylesheet'>
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
        <section id="Obehave">
            <h5 class="underline">?מה ברצונך להוסיף</h5>
            <article id="recTL">
                <a href="cevent2.php?id=<?php echo $row['kid_id']?>&kind=3" class="addEvTL">השתתפות בסדנא</a>
            </article>
            <article id="recTR">
                <a href="cevent4.php?id=<?php echo $row['kid_id']?>&kind=1" class="addEvTR">ציון לשבח</a>
            </article>
            <article id="recBL">
                <a href="cevent3.php?id=<?php echo $row['kid_id']?>&kind=2" class="addEvBL">אירוע משמעתי</a>
            </article>
            <article id="recBR">
                <a href="cevent.php?id=<?php echo $row['kid_id']?>&kind=4" class="addEvBR" >אירוע חריג</a>
            </article>
        </section>
        <div class="clear"></div>
    </main>
    <footer>
    </footer>
</body>

</html>
<?php mysqli_close($connection);?>