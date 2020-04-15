<?php 
  /*******************
  * WEBD Final Project - logout page
  * Name:     Mark Woods
  * Date:     April 15th, 2020
  ********************/ 

    require 'connect.php';

    if (isset($_SESSION))
        session_destroy(); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Logged out</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>You have been logged out. <a href='index.php'>Click here</a> to return to the homepage.</h2>
</body>
</html>