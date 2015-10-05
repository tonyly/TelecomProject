<?php

if(!isset($_COOKIE['loggedin'])){
  header('Location: index.html');
}

?>


<!DOCTYPE html>
<html>
<head>
  <title>Home Page</title>
  <!--<link type = "text/css" rel="stylesheet" href="dashboardcss.css"/>-->
</head>
<body>
  Welcome
  </body>
  <div class="menu">
    <ul>
      <li><a href="../logout.php">Logout</a></li>
      <li><a href="#">Add Service</a></li>
      <li><a href="#">Cancel Service</a></li>
      <li><a href="#">View Services</a></li>
      <li><a href="../displayaccounts.php">View Accounts</a></li>
    </ul>
    
  </div>
  <div class="main">

  </div>

 </body>
</html>



