<?php // Initialize the session
include 'config.php';
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
} ?>
<html lang="en">

<head>
    <title>Radsense - Radius MYSQL integration for pfsense</title>
    <!-- Meta Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="keywords" content="Modernize Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />
    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- //Meta Tags -->

    <!-- Style-sheets -->
    <!-- Bootstrap Css -->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <!-- Bootstrap Css -->
    <!-- Common Css -->
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <!--// Common Css -->
    <!-- Fontawesome Css -->
    <link href="css/fontawesome-all.css" rel="stylesheet">
    <!--// Fontawesome Css -->
    <!--// Style-sheets -->

    <!--web-fonts-->
    <link href="//fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!--//web-fonts-->
</head>

<body>
    <div class="bg-page py-5">
        <div class="container">
            <!-- main-heading -->
            <h2 class="main-title-w3layouts mb-2 text-center text-white">Delete Service</h2>
            <!--// main-heading -->
            <div class="form-body-w3-agile text-center w-lg-50 w-sm-75 w-100 mx-auto mt-5">

              <div class="form-body-w3-agile text-center w-lg-50 w-sm-75 w-100 mx-auto mt-5">

  <br>  <br>

  <?php
  $service = $_POST["delete"];
  $newservice = $_POST["newservice"];


  if(empty($newservice))
  {
    ?>

    <h4>Move users of service <?php echo $service ?> to different service:</h4>
      <form action="" method="post">
          <div class="form-group">
              <label>Service: </label>
              <select name="newservice">


                <?php

                $sql = "SELECT DISTINCT(groupname) FROM radgroupreply WHERE NOT groupname = '$service'";
                $result = mysqli_query($conn, $sql);

                while($row = mysqli_fetch_array($result)) {
                 ?>
                   <option><?php echo $row[groupname];?></option>

                         <?php
                           }
                          ?>
              </select>
          </div>

          <button type="submit" class="btn btn-primary error-w3l-btn">Move Users and Delete Service</button>
      </form>




    <?php

    $_SESSION["service"] = $service;
}
else {
  $delete = $_SESSION["service"];
  $sql = "UPDATE radusergroup SET groupname= '$newservice'  WHERE groupname='$delete'";

  if (mysqli_query($conn, $sql)) {

  echo '<h4>Users are moved to service '. "$newservice" .'</h4><br>';

  if (!mysqli_query($conn,"DELETE FROM radgroupreply WHERE groupname = '$delete'"))
  {
       echo mysqli_error($conn);
  } else {
      echo "Service $delete successfully deleted";
      unset($_SESSION["service"]);
  }

  } else {
     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }

}


  ?>



            </div>

        </div>
    </div>


    <!-- Required common Js -->
    <script src='js/jquery-2.2.3.min.js'></script>
    <!-- //Required common Js -->

    <!-- Js for bootstrap working-->
    <script src="js/bootstrap.min.js"></script>
    <!-- //Js for bootstrap working -->

</body>

</html>
