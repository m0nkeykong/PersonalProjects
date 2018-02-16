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
    <title>KinderKeeper - פרטים אישיים</title>
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
                <li id="selected">
                    <h6>
                        <a href="kid.php?id=<?php echo $row['kid_id']; ?>">פרטים אישיים</a>
                    </h6>
                </li
                ><li>
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
        <article id="asaflWrapper">
            <p class="underline">תאריך לידה:
                <span> <?php echo $row['kid_dob']; ?> </span> גיל:
                <span> <?php echo $row['kid_age']; ?> </span>
            </p>
            <p class="underline">שם האב:
                <span> <?php echo $row['kid_father']; ?> </span>
            </p>
            <p class="underline">שם האם:
                <span><?php echo $row['kid_mother']; ?> </span>
            </p>
            <p class="underline">עיר מגורים:
                <span><?php echo $row['kid_city']; ?></span> רחוב:
                <span> <?php echo $row['kid_address']; ?> </span>
            </p>

            <article id="redbox">
                <h5> חשוב לדעת</h5>
                <p>
                <?php echo $row['kid_important']; ?>
                </p>
            </article>
        </article>
    </main>
    <footer>
    </footer>
</body>

</html>
<?php mysqli_close($connection);?>