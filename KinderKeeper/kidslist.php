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
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>KinderKeeper - רשימת ילדים</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="includes/style.css" rel="stylesheet">
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
    <main id="kidsList">
    <?php
        $query = "SELECT * FROM 239_kidlist_table";
        $result = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($result)){?>
        <section class="child">
            <a href="kid.php?id=<?php echo $row["kid_id"];?>" 
            style="background: url('<?php echo $row["kid_img"];?>') center center no-repeat">
            </a>
            <h5>
                <?php echo $row["kid_name"];?>
            </h5>
        </section>
        <?php
        }?>
        <?php mysqli_free_result($result);?>
    </main>
    <footer>
    </footer>
</body>

</html>
<?php mysqli_close($connection);?>