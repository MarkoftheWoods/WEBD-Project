<?php

/*******************
* WEBD Final Project - event page
* Name:     Mark Woods
* Date:     March 12, 2020
********************/

require 'functions.php';

$eventID = filter_input(INPUT_GET, 'eventid', FILTER_VALIDATE_INT);

$pageTitle = "Event Details";

if ($eventID != null)
{
  $event = getEventData($eventID, $db);

  $query = "SELECT * FROM fight WHERE EventId = :eventID";
  $statement = $db->prepare($query);
  $statement->bindValue(':eventID', $eventID);
  $statement->execute();
  $fights = $statement->fetchAll();
}

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
    <?php if ($eventID != null): ?>
      <section id='main'>
        <span id="titleline"><h2><?= $event['EventName'] ?></h2><a id="editlink" href='addEvent.php?eventid=<?= $eventID ?>'>Edit</a></span>
        <p>Date: <?= $event['Date']?></p>

        <div id="fighttable">
        <h3>Fights</h3>
          <?php if ($fights != null): ?>
            <?php buildFightTable($fights, $db) ?>
          <?php endif ?>
        </div>

      </section>
      <?php require 'comments.php'; ?>
    <?php endif ?>
    </section>
</body>
</html>