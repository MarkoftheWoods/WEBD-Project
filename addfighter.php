<?php

/*******************
* WEBD Final Project - addfighter page
* Name:     Mark Woods
* Date:     March 25, 2020
********************/

require 'functions.php';
include 'php-image-resize-master\lib\ImageResize.php';
require 'authenticate.php';

$pageTitle = "Add Fighter";
$imageURL = null;

if (isset($_GET['fighterid']))
{
  $fighterID = filter_input(INPUT_GET, 'fighterid', FILTER_VALIDATE_INT);

  if ($fighterID) //Valid FighterID specified as GET parameter
  {
    $editMode = true;
    $pageTitle = "Edit Fighter";

    if (isset($_POST['fightername']))
    {
      $fighterName = filter_input(INPUT_POST, 'fightername', FILTER_SANITIZE_STRING);
      $birthDate = filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_STRING);
      $birthPlace = filter_input(INPUT_POST, 'birthplace', FILTER_SANITIZE_STRING);
      $wins = filter_input(INPUT_POST, 'wins', FILTER_VALIDATE_INT);
      $losses = filter_input(INPUT_POST, 'losses', FILTER_VALIDATE_INT);
      $draws = filter_input(INPUT_POST, 'draws', FILTER_VALIDATE_INT);
      $nocontests = filter_input(INPUT_POST, 'nocontests', FILTER_VALIDATE_INT);
  
  
      $query = "UPDATE fighter SET Name = :fightername, Birthdate = :birthDate, Birthplace = :birthPlace, Wins = :wins, Losses = :losses, Draws = :draws, NoContests = :nocontests
                     WHERE FighterID = :fighterid";
      $statement = $db->prepare($query);
  
      $statement->bindValue(':fightername', $fighterName);
      $statement->bindValue(':birthDate', $birthDate);
      $statement->bindValue(':birthPlace', $birthPlace);
      $statement->bindValue(':wins', $wins);
      $statement->bindValue(':losses', $losses);
      $statement->bindValue(':draws', $draws);
      $statement->bindValue(':nocontests', $nocontests);
      $statement->bindValue(':fighterid', $fighterID);
  
      if ($statement->execute())
      {
        $message = "Successfully edited $fighterName.";
      }
      else{
        $message = "Unable to edit fighter. Error: " . $statement->errorCode();
      }
    }
    else
    {
      if (isset($_SESSION['message']))
      {
        $message = $_SESSION['message'];
      }
    }
    $fighter = getFighterData($fighterID, $db);
    
  }
  else{
    $editMode = false;
    $message = "Unable to locate the requested data.";
  }  

  require 'editimage.php';
}
else //FighterID not specified as GET parameter
{
  $editMode = false;

  if (isset($_POST['fightername']))
  {
    $fighterName = filter_input(INPUT_POST, 'fightername', FILTER_SANITIZE_STRING);
    $birthDate = filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_STRING);
    $birthPlace = filter_input(INPUT_POST, 'birthplace', FILTER_SANITIZE_STRING);
    $wins = filter_input(INPUT_POST, 'wins', FILTER_VALIDATE_INT);
    $losses = filter_input(INPUT_POST, 'losses', FILTER_VALIDATE_INT);
    $draws = filter_input(INPUT_POST, 'draws', FILTER_VALIDATE_INT);
    $nocontests = filter_input(INPUT_POST, 'nocontests', FILTER_VALIDATE_INT);

    $query = "INSERT INTO `fighter` (`Name`, `Birthdate`, `Birthplace`, `Wins`, `Losses`, `Draws`, `NoContests`) 
                    VALUES (:fightername, :birthDate, :birthPlace, :wins, :losses, :draws, :nocontests)";
    $statement = $db->prepare($query);

    $statement->bindValue(':fightername', $fighterName);
    $statement->bindValue(':birthDate', $birthDate);
    $statement->bindValue(':birthPlace', $birthPlace);
    $statement->bindValue(':wins', $wins);
    $statement->bindValue(':losses', $losses);
    $statement->bindValue(':draws', $draws);
    $statement->bindValue(':nocontests', $nocontests);

    if ($statement->execute())
    {      
      $fighterList = getAllFighters($db);
      $fighter = end($fighterList);      
      $message = "Successfully added " . $fighter['Name'];
      require 'editimage.php';
      $imageURL = getImageURL($fighter['FighterID'], $db);
    }
    else{
      $message = "Unable to add fighter. Error: " + $statement->errorCode();
      $imageURL = null;
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
if(isset($fighterID))
  $imageURL = getImageURL($fighterID, $db);

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
      
      <form method="post" action="addfighter.php" enctype="multipart/form-data">
        <fieldset>
          <ul>
            <li>
              <label for="fightername">Name:</label>
              <?php if ($editMode): ?>
                <input id="fightername" name="fightername" type="text" value="<?= $fighter['Name'] ?>" required>
              <?php else: ?>
                <input id="fightername" name="fightername" type="text" required>
              <?php endif ?>              
            </li>
            <li>
              <label for="birthdate">Birthdate:</label>
              <?php if ($editMode): ?>
                <input id="birthdate" name="birthdate" type="date" value="<?= $fighter['Birthdate'] ?>" required>
              <?php else: ?>
                <input id="birthdate" name="birthdate" type="date" required>
              <?php endif ?> 
              
            </li>
            <li>
              <label for="birthplace">Birth place:</label>
              <?php if ($editMode): ?>
                <input id="birthplace" name="birthplace" type="text" value="<?= $fighter['Birthplace'] ?>" required>
              <?php else: ?>
                <input id="birthplace" name="birthplace" type="text" required>
              <?php endif ?>
              
            </li>
            <li>
              <label for="wins">Wins:</label>
              <?php if ($editMode): ?>
                <input id="wins" name="wins" type="number" min="0" value="<?= $fighter['Wins'] ?>">
              <?php else: ?>
                <input id="wins" name="wins" type="number" min="0" value="0">
              <?php endif ?>
            </li>
            <li>            
              <label for="losses">Losses:</label>
              <?php if ($editMode): ?>
                <input id="losses" name="losses" type="number" min="0" value="<?= $fighter['Losses'] ?>">
              <?php else: ?>
                <input id="losses" name="losses" type="number" min="0" value="0">
              <?php endif ?>
              
            </li>
            <li>            
              <label for="draws">Draws:</label>
              <?php if ($editMode): ?>
                <input id="draws" name="draws" type="number" min="0" value="<?= $fighter['Draws'] ?>">
              <?php else: ?>
                <input id="draws" name="draws" type="number" min="0" value="0">
              <?php endif ?>
              
            </li>
            <li>            
              <label for="nocontests">No Contests:</label>
              <?php if ($editMode): ?>
                <input id="nocontests" name="nocontests" type="number" min="0" value="<?= $fighter['NoContests'] ?>">
              <?php else: ?>
                <input id="nocontests" name="nocontests" type="number" min="0" value="0">
              <?php endif ?>
              
            </li>
            <li>
              <?php if ($imageURL != null): ?>
                <label for="deleteimage">Delete Image?</label>
                <input type="checkbox" name="deleteimage" id="deleteimage">                
              <?php else: ?>
                <label for="image">Upload image:</label>
                <input type="file" name="image" id="image">
              <?php endif ?>
            </li>
            <li>
              <?php if ($editMode): ?>
                <button formaction="addfighter.php?fighterid=<?= $fighterID?>">Edit fighter</button>
                <button formaction="delete.php?fighterid=<?= $fighterID?>">Delete fighter</button>
              <?php else: ?>
                <button>Add fighter</button>
              <?php endif ?>
            </li>
          </ul>
        </fieldset>
      </form>
      <div>
      <?php if (isset($filemessage)): ?>
        <p><?= $filemessage ?> </p>
      <?php endif ?>  
      </div>
    </section>

    <footer>
    </footer>
</body>
</html>