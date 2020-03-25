<?php

/*******************
* WEBD Final Project - fight page
* Name:     Mark Woods
* Date:     March 12, 2020
********************/

require 'connect.php';

$fightid = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);

if ($fightid != null)
{
  $query = "SELECT * FROM fight WHERE FightID = :fightID";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>WMMAL Fights</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
    <h1></h1>
    </header>

    <section>
    </section>
</body>
</html>