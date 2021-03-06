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
  $tempID = $_SESSION['kid_id'];
  $parentName = $_SESSION['user_name'];
  $query = "SELECT * FROM 239_kidlist_table WHERE '$tempID' = kid_id";  
  $result = mysqli_query($connection, $query);
  $row = mysqli_fetch_array($result);
  mysqli_free_result($result);
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
        <section id="parentList">
            <h5 class="underline"> בחר הורה </h5>
            <?php
            $query = "SELECT kid_father, kid_mother
                      FROM 239_kidlist_table
                      WHERE kid_mother <> '$parentName'";
            
            $result = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($result)){
            ?>
            <article class="parents">
                <a href="arrival.php?id=<?php echo $row['kid_father'];?>"> <?php echo $row['kid_father'];?> </a>
            </article>
            <article class="parents">
                <a href="arrival.php?id=<?php echo $row['kid_mother'];?>"> <?php echo $row['kid_mother'];?> </a>
            </article>
            <?php } mysqli_free_result($result);?>
            <div class="parents">
                <a href="external.php"> עדכן אוסף חיצוני </a>
            </div>
        </section>
    </main>
    <footer>
    </footer>
</body>

</html>
<?php 
mysqli_close($connection);?>