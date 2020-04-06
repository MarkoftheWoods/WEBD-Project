<?php

/*******************
* WEBD Final Project - event page
* Name:     Mark Woods
* Date:     March 12, 2020
********************/

$eventID = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);

$pageTitle = "Event Details";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>WMMAL Events</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
      <?php require 'header.php'; ?>
    </header>

    <section>
    </section>
</body>
</html>