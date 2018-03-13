<?php
session_start();
//get the user list from the json file
$json = file_get_contents("data/users.json");
$jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($json, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);

if(!empty($_POST["username"])){ 
    $_SESSION["username"] = $_POST["username"];
    $pass = $_POST["password"];

    foreach ($jsonIterator as $row) {
        if(is_array($row)) {
            if (($_SESSION["username"] == $row["username"]) && ($pass == $row["password"])){
                $_SESSION["username"] = $row["username"];
            }
        }
    }
    if($_SESSION["username"] == "admin") {
        header("LOCATION: adminindex.php");
    } else if ($_SESSION["username"] == "user"){
        header("LOCATION: userindex.php");
    } else {
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="includes/js/jquery-3.2.1.min.js"></script>
    <title>Login Page</title>
</head>
<body id="wrapper">
    <header>
    </header>
    <main>
    <div class="wrapper">
        <form class="form-signin" method="POST">       
            <h2 class="form-signin-heading">Please login</h2>
            <input type="text" class="form-control" name="username" placeholder="Email Address" required="" autofocus="" />
            <input type="password" class="form-control" name="password" placeholder="Password" required=""/>      
            <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>   
        </form>
    </div>
    </main>
</body>
</html>