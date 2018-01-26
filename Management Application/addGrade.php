<?php session_start(); 
require "templates/header.php" ?>

<title>Software Company Database Management - Add Grade</title>
</head>
<body style="max-width: 1000px; margin: 0 auto;">
<br><h1 style="text-align: center;">Add Monthly Grade</h1><br>
<div class="row">
    <div class="col-3">
        <a href="engineer.php" style="margin: 0 auto;"><button type="button" class="btn btn-info">Back</button></a>
    </div>
    <div class="col-6">
        <form method="post">
            <div class="form-group">
                <label for="engineer_id">Enter Engineer ID</label>
                <input type="text" name="engineer_id" class="form-control" id="engineer_id" placeholder="Engineer ID" required>
            </div>
            <div class="form-group">
               <center> <input type="submit" name="submit" value="Continue" class="btn btn-primary"> </center>
            </div>
        </form>
    </div>
    <div class="col-sm"> </div>
</div>

<?php
require "config.php";
require "common.php";
$db = new PDO($dsn, $username, $password, $options);


if (isset($_POST['submit']))
{
    $temp_id = $_POST['engineer_id']; 
    $_SESSION['engineer_id'] = $temp_id;
    $sql = $db->query("SELECT *
                            FROM projects NATURAL JOIN takespart
                            WHERE engineer_id = '$temp_id'");
        $sql = $sql->fetchAll();

            ?>
            <blockquote>Engineer ID Selected Successfuly.</blockquote> <br>
            <div class="col-6"style="text-align: center; margin: 0 auto;">
                <form method="post" >
                  <br><h4>Choose Projects</h4>

                    <label for="project_number" style="float: left;">Project</label>
                    <select class="form-control" id="project_number" name="project_number">
                    <?php
                    foreach ($sql as $row)
                    {?>
                    <option value="<?php echo escape($row["project_number"]); ?>"> <?php echo escape($row["project_name"]); ?> </option>
                    <?php
                    }
                    ?>
                    </select><br>
                
                <div class="form-group">
                <center> <input id="submit2" type="submit" name="submit2" value="Continue" class="btn btn-primary"> </center>
                </div>
            </form>
            </div>
        <?php  
        }
        if (isset($_POST['submit2']))
        {
            $temp_projnum = $_POST['project_number'];
            $_SESSION['project_number'] = $temp_projnum;


        ?>    
            <blockquote>Projects Selected Succesfully.</blockquote> <br>
            <div class="row">
            <div class="col-3">
            </div>
            <div class="col-6">
                <form method="post">
                <br><h4 style="text-align: center;">Add Grade To Month</h4>

                <label for="grade">Grade</label>
                <select class="form-control" id="grade" name="grade">
                <?php
                for ($i=1; $i<11; $i++)
                {?>
                <option value="<?php echo escape($i); ?>"> <?php echo escape($i); ?> </option>
                <?php
                }
                ?>
                </select><br>

                <label for="month">Month</label>
                <select class="form-control" id="month" name="month">
                <?php
                for ($j=1; $j<13; $j++)
                {?>
                <option value="<?php echo escape($j); ?>"> <?php echo escape($j); ?> </option>
                <?php
                }
                ?>
                </select><br>

                <div class="form-group">
                <center> <input type="submit" name="submit3" value="Add" class="btn btn-primary"> </center>
                </div>
            </form>
             </div>
                <div class="col-sm"></div>
            </div>
            <?php   
        }

        if (isset($_POST['submit3']) )
            { ?>
            <?php
   
                $temp_id = $_SESSION['engineer_id']; 
                $temp_projnum = $_SESSION['project_number'];
                $temp_grade = $_POST['grade'];
                $temp_month = $_POST['month'];
                $sql2 = $db->query("INSERT INTO monthly_grade (grade, month, engineer_id, project_number)
                                    VALUES ('$temp_grade', '$temp_month', '$temp_id', '$temp_projnum')");
?>
<blockquote>Grade Has Been Added Succesfully.</blockquote> <br>
	       <?php }
require "templates/footer.php"; ?>