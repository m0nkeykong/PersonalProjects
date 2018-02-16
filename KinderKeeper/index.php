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

$tempNAME = $_SESSION['user_name'];
$query = "SELECT * FROM 239_userlist_table
          WHERE user_name = '$tempNAME'";

$result = mysqli_query($connection, $query);
$row = mysqli_fetch_array($result);
mysqli_free_result($result);
$_SESSION['user_img'] = $row['user_img'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>KinderKeeper - לוח מודעות</title>
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
            require('headerUserName.php');
        ?>
        <article>
            <h1> לוח מודעות </h1>
        </article>
    </header>
    <main>
        <section>
            <h5 class="underline">היום, 21/12/2017</h5>
            <section class="message">
                <article class="topMessage">
                    <p> הימים הקרובים צפוים להיות קרירים מהרגיל לכן הינכם מתבקשים לשלוח את ילדיכם לבושים בהתאם.</p>
                </article>
                <article class="bottomMessage">
                    <a href="#" class="shareMessage"></a>
                    <a href="#" class="editMessage"></a>
                    <a href="#" class="deleteMessage"></a>
                    <a href="#" class="readMessage"></a>
                </article>
            </section>
        </section>
        <section>
            <h5 class="underline">אתמול, 20/12/2017</h5>
            <section class="message">
                <article class="topMessage">
                    <p> הורים יקרים שלום! <br> נא לא לשכוח להביא מחר 30 ש"ח לטובת סופגניות לחנוכה.</P>
                </article>
                <article class="bottomMessage">
                    <a href="#" class="shareMessage"></a>
                    <a href="#" class="editMessage"></a>
                    <a href="#" class="deleteMessage"></a>
                    <a href="#" class="readMessage"></a>
                </article>
            </section>
            <section class="message">
                <article class="topMessage">
                    <p>מחר בשעה 18:00 צוות הגן יכריז על הילד שזכה בתואר מצטיין החודש והודעה זו תפורסם בלוח העדכונים.</p>
                </article>
                <article class="bottomMessage">
                    <a href="#" class="shareMessage"></a>
                    <a href="#" class="editMessage"></a>
                    <a href="#" class="deleteMessage"></a>
                    <a href="#" class="readMessage"></a>
                </article>
            </section>
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

<?php
mysqli_close($connection);?>