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


if(!empty($_POST["username"])){
  $query = "SELECT * FROM 239_userlist_table WHERE user_login ='" . $_POST["username"] . "' AND user_pass = '" . $_POST["password"] . "'";

  $result = mysqli_query($connection, $query);
  $row = mysqli_fetch_array($result);
  mysqli_free_result($result);
  
  if(is_array($row)) {
      $_SESSION["user_name"] = $row["user_name"];
      $_SESSION["garden_name"] = $row["garden_name"];
      $_SESSION["role"] = $row["role"]; 
      header("LOCATION: index.php");
  } else{
    $message = "Invalid Username or Password";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="includes/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Alef" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="includes/js/jquery-3.2.1.min.js"></script>
    <title>קינדרקיפר | KinderKeeper</title>
    <link rel="shortcut icon" href="images/minilogo.ico"/>
</head>

<body id="wrapper">
    <header>
        <a href="index.php"></a>
    </header>
    <main>
        <h1> קינדרקיפר | KinderKeeper </h1>
        <section class="middle">
        <h4 class="underline"> כניסה למערכת <h4>
        </section>
        <section class="login">
            <form method="POST" action="login.php" autocomplete="off">
                <input type="text" name="username" placeholder="שם משתמש" required>
                <input type="password" name="password" placeholder="סיסמא" required>
                <button type="submit">
                <img src="images/loginRegular.jpg" width="200" height="30" alt="submit" name="login" value="כניסה"/>
                </button>
                <button type="submit">
                <img src="images/loginGoogle.jpg" width="200" height="30" alt="submit" name="login" value="כניסה"/>
                </button>
                <div> <?php if(isset($message)) { echo $message;} ?> </div>
            </form>
        </section>
    </main>
</body>

</html>
<?php mysqli_close($connection);?>