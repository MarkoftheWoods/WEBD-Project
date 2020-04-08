<?php

/*******************
* WEBD Final Project - fighter page
* Name:     Mark Woods
* Date:     March 12, 2020
********************/

require 'functions.php';

$fighterID = filter_input(INPUT_GET, 'fighterid', FILTER_VALIDATE_INT);
$fighterList = getAllFighters($db);
$pageTitle = "Fighter Profile";

if ($fighterID != null)
{
  $fighter = getFighterData($fighterID, $db);

  $query = "SELECT * FROM fight WHERE RedCornerFighter = :fighterID OR BlueCornerFighter = :fighterID";
  $statement = $db->prepare($query);
  $statement->bindValue(':fighterID', $fighterID);
  $statement->execute();
  $fights = $statement->fetchAll();

  $query = "SELECT * FROM image WHERE FighterID = :fighterID";
  $statement = $db->prepare($query);
  $statement->bindValue(':fighterID', $fighterID);
  $statement->execute();
  $image = $statement->fetch();
  
  if (isset($image['ImageURL']))
    $imageURL = $image['ImageURL'];
  else
    $imageURL = null;
}

if (isset($_SESSION['message']))
{
  $message = $_POST['message'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Fighter Profile</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
      <?php require 'header.php'; ?>
    </header>
    <div>
      <?php if (isset($message)): ?>
        <p id="alert"><?= $message ?> </p>
      <?php endif ?>
    </div>

    <?php if ($fighterID != null): ?>
      <section id='main'>
        <span id="titleline"><h2><?= $fighter['Name'] ?></h2><a id="editlink" href='addfighter.php?fighterid=<?= $fighterID ?>'>Edit</a></span>
        <div>
          <?php if(isset($imageURL)): ?>
            <img src='images/<?= $imageURL ?>' alt='<?= $fighter['Name'] ?>'></img>
          <?php endif ?>
        </div>
        <p><?= $fighter['Wins']?>-<?= $fighter['Losses']?>-<?= $fighter['Draws']?>  (<?= $fighter['NoContests']?>)</p>
        <ul>
          <li>From: <?= $fighter['Birthplace'] ?></li>
          <li>Born: <?= $fighter['Birthdate'] ?></li>        
        </ul>

        <div id="fighttable">
          <h3>Fights</h3>
          <?php if ($fights != null): ?>
            <?php buildFightTable($fights, $db) ?>
          <?php else: ?>
            <p>No fights to display</p>
          <?php endif ?>
        </div>
      </section>
      <?php require 'comments.php'; ?>
    <?php endif ?>

    <footer>
    </footer>
</body>
</html>