<?php
  /*******************
  * WEBD Final Project - Functions page
  * Name:     Mark Woods
  * Date:     March 12, 2020
  ********************/ 

require 'connect.php';

if (!isset($_SESSION))
{
  session_start();
}
else
{
  if (isset($_SESSION['User']))
  {
    $user = $_SESSION['User'];
    if ($user['Role'] == "ADMIN")
      $adminUser = true;
  }
}

// Accepts a username, password, and reference to a PDO object
// Pulls the user data from the database and verifies the password against the stored hash.
// Returns null if password is not verified or user is not found.
function validateLogin($username, $password, $db)
{
  $query = "SELECT * FROM user WHERE Username = :username";
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->execute();
  $user = $statement->fetch();

  //Hashed password
  if (!password_verify($password, $user['Password']))
    $user = null; 

  
  //Plaintext password
  //if ($user['Password'] != $password)
  //  $user = null;
  

  return $user;
}

// Accepts a fighterID and reference to a PDO object
// Pulls the fighter ID from the database and returns it
// Returns null if fighterID is not found.
function getFighterData($id, $db)
{
  $query = "SELECT * FROM fighter WHERE FighterID = :id";
  $statement = $db->prepare($query);
  $statement->bindValue(':id', $id);
  $statement->execute();
  $foundFighter = $statement->fetch();

  return $foundFighter;
}

// Accepts a commentID and reference to a PDO object
// Pulls the comment ID from the database and returns it
// Returns null if commentID is not found.
function getCommentData($id, $db)
{
  $query = "SELECT * FROM comment WHERE CommentID = :id";
  $statement = $db->prepare($query);
  $statement->bindValue(':id', $id);
  $statement->execute();
  $foundComment = $statement->fetch();

  return $foundComment;
}

// Accepts a eventID and reference to a PDO object
// Pulls the event ID from the database and returns it
// Returns null if eventID is not found.
function getEventData($id, $db)
{
  $query = "SELECT * FROM event WHERE EventID = :id";
  $statement = $db->prepare($query);
  $statement->bindValue(':id', $id);
  $statement->execute();
  $foundEvent = $statement->fetch();

  return $foundEvent;
}

// Accepts a userID and reference to a PDO object
// Pulls the user ID from the database and returns it
// Returns null if userID is not found.
function getUserData($id, $db)
{
  $query = "SELECT * FROM user WHERE UserID = :id";
  $statement = $db->prepare($query);
  $statement->bindValue(':id', $id);
  $statement->execute();
  $foundUser = $statement->fetch();

  return $foundUser;
}

// Accepts a fightID and reference to a PDO object
// Pulls the fight ID from the database and returns it
// Returns null if fightID is not found.
function getFightData($id, $db)
{
  $query = "SELECT * FROM fight WHERE FightID = :id";
  $statement = $db->prepare($query);
  $statement->bindValue(':id', $id);
  $statement->execute();
  $foundFight = $statement->fetch();

  return $foundFight;
}

// Accepts a reference to a PDO object
// Pulls the entire list of fighters from the database and returns it
//  as an array.
function getAllFighters($db)
{
  $query = "SELECT * FROM fighter";
  $statement = $db->prepare($query);
  $statement->execute();
  $fighters = $statement->fetchAll();

  return $fighters;
}

// Accepts a reference to a PDO object
// Pulls the entire list of events from the database and returns it
//  as an array.
function getAllEvents($db)
{
  $query = "SELECT * FROM event";
  $statement = $db->prepare($query);
  $statement->execute();
  $events = $statement->fetchAll();

  return $events;
}

// Accepts a reference to a PDO object
// Pulls the entire list of users from the database and returns it
//  as an array.
function getAllUsers($db)
{
  $query = "SELECT * FROM user";
  $statement = $db->prepare($query);
  $statement->execute();
  $users = $statement->fetchAll();

  return $users;
}

// Accepts a reference to a fight object and a reference to a PDO object
// Formats the fight into a readable string with the most relevant information.
// Returns a string.
function formatFightRow($fight, $db)
{
  if ( ($fight['RedCornerResult'] == "W") && ($fight['BlueCornerResult'] == "L") )
  {
    $winner = getFighterData($fight['RedCornerFighter'], $db);
    $loser = getFighterData($fight['BlueCornerFighter'], $db);
  }
  else if ( ($fight['RedCornerResult'] == "L") && ($fight['BlueCornerResult'] == "W") )
  {
    $loser = getFighterData($fight['RedCornerFighter'], $db);
    $winner = getFighterData($fight['BlueCornerFighter'], $db);
  }
  else{
    $loser = getFighterData($fight['RedCornerFighter'], $db);
    $winner = getFighterData($fight['BlueCornerFighter'], $db);
  }

  if($loser == null)
  {
    $loser['Name'] = "Unknown fighter";
    $loser['FighterID'] = -1;
  }

  if($winner == null)
  {
    $winner['Name'] = "Unknown fighter";
    $winner['FighterID'] = -1;
  }

  $output = "<td><a href='fighter.php?fighterid=" . $winner['FighterID'] . "'>". $winner['Name'] . 
            "</a></td><td>defeated</td><td><a href='fighter.php?fighterid=" . $loser['FighterID'] . "'>" . $loser['Name'] . 
            "</a></td><td><a href='fight.php?fightid=" . $fight['FightID'] . "'>Details</a></td>";

  //$output = "<a href='fight.php?fightid=" . $fight['FightID'] . "'>" . $fighterResult . " vs " . $otherFighter['Name'] . "</a>";

  return $output; 
}

function getImageURL($fighterID, $db)
{
  $query = "SELECT * FROM image WHERE FighterID = :id";
  $statement = $db->prepare($query);
  $statement->bindValue(':id', $fighterID);
  $statement->execute();
  $foundURL = $statement->fetch();

  if (isset($foundURL['ImageURL']))
    $returnVal = $foundURL['ImageURL'];
  else
    $returnVal = null;

  return $returnVal;
}

function buildFightTable($fightList, $db)
{
  
  echo '<table id="fighttable">';
  
  foreach ($fightList as $fight)
  {
    echo "<tr>";
    echo formatFightRow($fight, $db);
    echo "</tr>";
  }

  echo '</table>';
}

$fighterList = getAllFighters($db);
$eventList = getAllEvents($db);
$resultTypes = array("W", "L", "D", "NC");

?>