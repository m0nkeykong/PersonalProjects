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
  $query = "SELECT * FROM 239_kidlist_table  WHERE '$tempID' = kid_id";  
  $result = mysqli_query($connection, $query);
  $row = mysqli_fetch_array($result);
  mysqli_free_result($result);
  
  
  $sheilta = "SELECT * FROM 239_kid_events
              WHERE kid_id = '$tempID'";
  
  $result2 = mysqli_query($connection, $sheilta);
  $kind1= 0; $kind2= 0; $kind3=0; $kind4=0;
  while ($row2 = mysqli_fetch_assoc($result2)){
      if($row2['kind'] == 1)
          $kind1++;
      
      if($row2['kind'] == 2)
          $kind2++;
  
      if($row2['kind'] == 3)
          $kind3++;
  
      if($row2['kind'] == 4)
          $kind4++;
      }
  
  $total = $kind1 + $kind2 + $kind3 + $kind4;
  $kind1 = ($kind1 / $total) * 100;
  $kind2 = ($kind2 / $total) * 100;
  $kind3 = ($kind3 / $total) * 100;
  $kind4 = ($kind4 / $total) * 100;
  
  $row2 = mysqli_fetch_assoc($result2);
  mysqli_free_result($result2);
  
  echo $row2['KID'];


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
    <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/easy-pie-chart/2.1.6/jquery.easypiechart.js"></script>
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
                ><li id="selected">
                    <h6>
                        <a href="pieChart.php?id=<?php echo $row['kid_id']; ?>">גרף התפתחות</a>
                    </h6>
                </li>
            </ul>
        </nav>
        <section id="asaflWrapper">
            <h5 class="underline"> גרף התפלגות אירועים - <?php echo $row['kid_name'] ?> </h5>
            <div id="chartContainer">
                <script type="text/javascript"> 
                    window.onload = function () {
                    $("#chartContainer").CanvasJSChart({
                        axisY: {
                            title: "Products in %"
                        },
                        legend: {
                            verticalAlign: "center",
                            horizontalAlign: "right"
                        },
                        data: [{
                            type: "pie",
                            showInLegend: true,
                            toolTipContent: "{label} <br/> {y} %",
                            indexLabel: "{y} %",
                            dataPoints: [
                                { label: "ציון לשבח", y: <?php echo $kind1 ?>, legendText: "ציון לשבח" },
                                { label: "אירוע משמעתי", y: <?php echo $kind2 ?>, legendText: "אירוע משמעתי" },
                                { label: "השתתפות בסדנא", y: <?php echo $kind3 ?>, legendText: "השתתפות בסדנא" },
                                { label: "אירוע חריג", y: <?php echo $kind4 ?>, legendText: "אירוע חריג" },
                ]
            }
        ]
    });
} 
                    </script>
            </div>
        </section>
    </main>
    <footer>
    </footer>
</body>
</html>
<?php mysqli_close($connection);?>