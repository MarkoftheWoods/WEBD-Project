<?php

/*******************
* WEBD Final Project - addfight page
* Name:     Mark Woods
* Date:     March 25, 2020
********************/

require 'functions.php';
//require 'authenticate.php';

$pageTitle = "Add Fight";

if (isset($_GET['fightid']))
{
  $fightID = filter_input(INPUT_GET, 'fightid', FILTER_VALIDATE_INT);

  if ($fightID)
  {
    $editMode = true;
    $pageTitle = "Edit Fight";

    if (isset($_POST['redfighter']))
    {
      $eventID = filter_input(INPUT_POST, 'eventid', FILTER_VALIDATE_INT);
      $redFighter = filter_input(INPUT_POST, 'redfighter', FILTER_VALIDATE_INT);      
      $blueFighter = filter_input(INPUT_POST, 'bluefighter', FILTER_VALIDATE_INT);
      $weightclass = filter_input(INPUT_POST, 'weightclass', FILTER_SANITIZE_STRING);
      $resultType = filter_input(INPUT_POST, 'result', FILTER_SANITIZE_STRING);
      $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
      $roundEnded = filter_input(INPUT_POST, 'round', FILTER_VALIDATE_INT);  
      $redResult = filter_input(INPUT_POST, 'redresult', FILTER_SANITIZE_STRING);
      $blueResult = filter_input(INPUT_POST, 'blueresult', FILTER_SANITIZE_STRING);
      
      
      $query = "UPDATE fight SET  EventID = :eventid, 
                                  RedCornerFighter = :redfighter, 
                                  BlueCornerFighter = :bluefighter, 
                                  WeightClass = :weightclass, 
                                  ResultType = :result, 
                                  ResultDescription = :description, 
                                  RoundEnded = :roundended, 
                                  RedCornerResult = :redresult,
                                  BlueCornerResult = :blueresult
                     WHERE FightID = :fightid";
      $statement = $db->prepare($query);
  
      $statement->bindValue(':eventid', $eventID);
      $statement->bindValue(':redfighter', $redFighter);
      $statement->bindValue(':bluefighter', $blueFighter);
      $statement->bindValue(':weightclass', $weightclass);
      $statement->bindValue(':result', $resultType);
      $statement->bindValue(':description', $description);
      $statement->bindValue(':roundEnded', $roundEnded);
      $statement->bindValue(':redresult', $redResult);
      $statement->bindValue(':blueresult', $blueResult);
      $statement->bindValue(':fightid', $fightID);
  
      if ($statement->execute())
      {
        $message = "Successfully edited fight.";
      }
      else{
        $message = "Unable to edit fight. Error: " . $statement->errorCode();
      }
    }
    else
    {
      if (isset($_SESSION['message']))
      {
        $message = $_SESSION['message'];
      }
    }
    $fight = getFightData($fightID, $db);
  }
  else{
    $editMode = false;
    $message = "Unable to locate the requested data.";
  }  
}
else
{
  $editMode = false;

  if (isset($_POST['redfighter']))
    {
      $eventID = filter_input(INPUT_POST, 'eventid', FILTER_VALIDATE_INT);
      $redFighter = filter_input(INPUT_POST, 'redfighter', FILTER_VALIDATE_INT);      
      $blueFighter = filter_input(INPUT_POST, 'bluefighter', FILTER_VALIDATE_INT);
      $weightclass = filter_input(INPUT_POST, 'weightclass', FILTER_SANITIZE_STRING);
      $resultType = filter_input(INPUT_POST, 'result', FILTER_SANITIZE_STRING);
      $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
      $roundEnded = filter_input(INPUT_POST, 'round', FILTER_VALIDATE_INT);  
      $redResult = filter_input(INPUT_POST, 'redresult', FILTER_SANITIZE_STRING);
      $blueResult = filter_input(INPUT_POST, 'blueresult', FILTER_SANITIZE_STRING);


    $query = "INSERT INTO `fight` (`EventID`, `RedCornerFighter`, `BlueCornerFighter`, `WeightClass`, `ResultType`, `ResultDescription`, `RoundEnded`, `RedCornerResult`, `BlueCornerResult`) 
                    VALUES (:eventid, :redfighter, :bluefighter, :weightclass, :result, :description, :roundEnded, :redresult, :blueresult)";
    
    $statement = $db->prepare($query);

    $statement->bindValue(':eventid', $eventID);
    $statement->bindValue(':redfighter', $redFighter);
    $statement->bindValue(':bluefighter', $blueFighter);
    $statement->bindValue(':weightclass', $weightclass);
    $statement->bindValue(':result', $resultType);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':roundEnded', $roundEnded);
    $statement->bindValue(':redresult', $redResult);
    $statement->bindValue(':blueresult', $blueResult);

    if ($statement->execute())
    {
      $message = "Successfully added fight.";
    }
    else{
      $message = "Unable to add fight. Error: " + $statement->errorCode();
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
  <title><?= $pageTitle ?></title>
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
      
      <form method="post" action="addfight.php">
        <fieldset>
          <ul>
            <li>
              <label for="eventid">Event:</label>
              <select id="eventlist" name="eventid">
              <option value="" selected disabled hidden><i>Choose an event</i></option>
                <?php foreach ($eventList as $listItem): ?>
                  <?php if ( ($editMode) && ($listItem['EventID'] == $fight['EventID']) ): ?>
                      <option value='<?= $listItem['EventID'] ?>' selected><?= $listItem['EventName'] ?></option>
                  <?php else: ?>
                    <option value='<?= $listItem['EventID'] ?>'><?= $listItem['EventName'] ?></option>
                  <?php endif ?>
                <?php endforeach ?>
              </select>
            </li>
            <li>
              <label for="redfighter">Red Corner:</label>
              <select id="redfighter" name="redfighter">
                <option value="" selected disabled hidden><i>Choose a fighter</i></option>
                <?php foreach ($fighterList as $listItem): ?>
                  <?php if ( ($editMode) && ($listItem['FighterID'] == $fight['RedCornerFighter']) ): ?>
                    <option value='<?= $listItem['FighterID'] ?>' selected><?= $listItem['Name'] ?></option>
                  <?php else: ?>
                    <option value='<?= $listItem['FighterID'] ?>'><?= $listItem['Name'] ?></option>
                  <?php endif ?>
                <?php endforeach ?>
              </select>
              <select id="redresult" name="redresult">
                <option value="" selected disabled hidden><i>Choose a result</i></option>
                <option value='W'>W</option>
                <option value='L'>L</option>
                <option value='D'>D</option>
                <option value='NC'>NC</option>
              </select>             
            </li>
            <li>
              <label for="bluefighter">Blue Corner:</label>
              <select id="bluefighter" name="bluefighter">
                <option value="" selected disabled hidden><i>Choose a fighter</i></option>
                <?php foreach ($fighterList as $listItem): ?>
                  <?php if ( ($editMode) && ($listItem['FighterID'] == $fight['BlueCornerFighter']) ): ?>
                    <option value='<?= $listItem['FighterID'] ?>' selected><?= $listItem['Name'] ?></option>
                  <?php else: ?>
                    <option value='<?= $listItem['FighterID'] ?>'><?= $listItem['Name'] ?></option>
                  <?php endif ?>
                <?php endforeach ?>
              </select>
              <select id="blueresult" name="blueresult">
                <option value="" selected disabled hidden><i>Choose a result</i></option>
                <option value='W'>W</option>
                <option value='L'>L</option>
                <option value='D'>D</option>
                <option value='NC'>NC</option>
              </select>          
            </li>
            <li>
              <label for="weightclass">Weightclass</label>
              <select id="weightclass" name="weightclass">
                <option value="" selected disabled hidden><i>Choose a weightclass</i></option>
                <option value='Flyweight'>Flyweight</option>
                <option value='Bantamweight'>Bantamweight</option>
                <option value='Featherweight'>Featherweight</option>
                <option value='Lightweight'>Lightweight</option>
                <option value='Welterweight'>Welterweight</option>
                <option value='Middleweight'>Middleweight</option>
                <option value='Light-Heavyweight'>Light-Heavyweight</option>
                <option value='Heavyweight'>Heavyweight</option>
                <option value='Catchweight'>Catchweight</option>
                <option value='Other'>Other</option>
              </select>             
            </li>
            <li>
              <label for="result">Result</label>
              <select id="result" name="result">
                <option value="" selected disabled hidden><i>Choose a result</i></option>
                <option value='KO'>KO  (Knockout)</option>
                <option value='TKO'>TKO (Technical knockout)</option>
                <option value='SUB'>SUB (Submission)</option>
                <option value='DEC'>DEC (Decision)</option>
                <option value='DQ'>DQ  (Disqualification)</option>
                <option value='NC'>NC (No contest)</option>
              </select>             
            </li>
            <li>
              <label for="description">Result description:</label>
              <?php if ($editMode): ?>
                <input id="description" name="description" type="text" value="<?= $fight['ResultDescription'] ?>">
              <?php else: ?>
                <input id="description" name="description" type="text" required>
              <?php endif ?>
            </li>
            <li>            
              <label for="round">Round:</label>
              <?php if ($editMode): ?>
                <input id="round" name="round" type="number" min="1" value="<?= $fight['RoundEnded'] ?>">
              <?php else: ?>
                <input id="round" name="round" type="number" min="1">
              <?php endif ?>              
            </li>
            <li>
              <?php if ($editMode): ?>
                <button formaction="addfight.php?fightid=<?= $fightID?>">Edit fighter</button>
                <button formaction="delete.php?fightid=<?= $fightID?>">Delete fighter</button>
              <?php else: ?>
                <button>Add fight</button>
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