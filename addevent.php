<?php

/*******************
* WEBD Final Project - event page
* Name:     Mark Woods
* Date:     March 12, 2020
********************/

require 'functions.php';
//require 'authenticate.php';

$pageTitle = "Add Event";

if (isset($_GET['eventid']))
{
  $eventID = filter_input(INPUT_GET, 'eventid', FILTER_VALIDATE_INT);

  if ($eventID)
  {
    $editMode = true;
    $pageTitle = "Edit Event";

    if (isset($_POST['eventname']))
    {
      $eventName = filter_input(INPUT_POST, 'eventname', FILTER_SANITIZE_STRING);
      $eventDate = filter_input(INPUT_POST, 'eventdate', FILTER_SANITIZE_STRING);
      $eventPromotion = filter_input(INPUT_POST, 'promotion', FILTER_SANITIZE_STRING);  
  
      $query = "UPDATE event SET EventName = :eventname, Date = :eventDate, Promotion = :promotion
                     WHERE EventID = :eventid";
      $statement = $db->prepare($query);
  
      $statement->bindValue(':eventname', $eventName);
      $statement->bindValue(':eventDate', $eventDate);
      $statement->bindValue(':promotion', $eventPromotion);
      $statement->bindValue(':eventid', $eventID);
  
      if ($statement->execute())
      {
        $message = "Successfully edited $eventName.";
      }
      else{
        $message = "Unable to edit event. Error: " . $statement->errorCode();
      }
    }
    else
    {
      if (isset($_SESSION['message']))
      {
        $message = $_SESSION['message'];
      }
    }


    $event = getEventData($eventID, $db);
  }
  else{
    $editMode = false;
    $message = "Unable to locate the requested data.";
  }  
}
else
{
  $editMode = false;

  if (isset($_POST['eventname']))
  {
    $eventName = filter_input(INPUT_POST, 'eventname', FILTER_SANITIZE_STRING);
    $eventDate = filter_input(INPUT_POST, 'eventdate', FILTER_SANITIZE_STRING);
    $promotion = filter_input(INPUT_POST, 'promotion', FILTER_SANITIZE_STRING);

    $query = "INSERT INTO `event` (`EventName`, `Date`, `Promotion`) 
                    VALUES (:eventname, :eventdate, :promotion)";
    $statement = $db->prepare($query);

    $statement->bindValue(':eventname', $eventName);
    $statement->bindValue(':eventdate', $eventDate);
    $statement->bindValue(':promotion', $promotion);

    if ($statement->execute())
    {
      $message = "Successfully added $eventName.";
    }
    else{
      $message = "Unable to add event. Error: " . $statement->errorCode();
    }
  }
  else
  {
    if (isset($_SESSION['message']))
    {
      $message = $_SESSION['message'];
    }
  }
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

    <section id='sidenavbar'>
    </section>

    <section id='main'>
      <?php if (isset($message)): ?>
        <p id="alert"><?= $message ?> </p>
      <?php endif ?>
      
      <form method="post" action="addevent.php">
        <fieldset>
          <ul>
            <li>
              <label for="eventname">Event Name:</label>
              <?php if ($editMode): ?>
                <input id="eventname" name="eventname" type="text" value="<?= $event['EventName'] ?>" required>
              <?php else: ?>
                <input id="eventname" name="eventname" type="text" required>
              <?php endif ?>              
            </li>
            <li>
              <label for="eventdate">Event date:</label>
              <?php if ($editMode): ?>
                <input id="eventdate" name="eventdate" type="date" value="<?= $event['Date'] ?>" required>
              <?php else: ?>
                <input id="eventdate" name="eventdate" type="date" required>
              <?php endif ?>               
            </li>
            <li>
              <label for="promotion">Promotion:</label>
              <?php if ($editMode): ?>
                <input id="promotion" name="promotion" type="text" value="<?= $event['Promotion'] ?>" required>
              <?php else: ?>
                <input id="promotion" name="promotion" type="text" required>
              <?php endif ?>
              
            </li>
            <li>
              <?php if ($editMode): ?>
                <button formaction="addevent.php?eventid=<?= $eventID?>">Edit event</button>
                <button formaction="delete.php?eventid=<?= $eventID?>">Delete event</button>
              <?php else: ?>
                <button>Add Event</button>
              <?php endif ?>
            </li>

          </ul>
        </fieldset>
      </form>
    </section>

    <footer>
    </footer>
</body>
</html>