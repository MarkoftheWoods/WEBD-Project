<?php
  /*******************
  * WEBD Final Project - Functions page
  * Name:     Mark Woods
  * Date:     March 12, 2020
  ********************/ 

require 'connect.php';

function getFighterData($id, $db)
{
  $query = "SELECT * FROM fighter WHERE FighterID = :id";
  $statement = $db->prepare($query);
  $statement->bindValue(':id', $id);
  $statement->execute();
  $foundFighter = $statement->fetch();

  return $foundFighter;
}

function getAllFighters($db)
{
  $query = "SELECT * FROM fighter";
  $statement = $db->prepare($query);
  $statement->execute();
  $fighters = $statement->fetchAll();

  return $fighters;
}

function getAllEvents($db)
{
  $query = "SELECT * FROM event";
  $statement = $db->prepare($query);
  $statement->execute();
  $events = $statement->fetchAll();

  return $events;
}

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

function getCommentData($id, $db)
{
  $query = "SELECT * FROM comment WHERE CommentID = :id";
  $statement = $db->prepare($query);
  $statement->bindValue(':id', $id);
  $statement->execute();
  $foundComment = $statement->fetch();

  return $foundComment;
}

function getEventData($id, $db)
{
  $query = "SELECT * FROM event WHERE EventID = :id";
  $statement = $db->prepare($query);
  $statement->bindValue(':id', $id);
  $statement->execute();
  $foundEvent = $statement->fetch();

  return $foundEvent;
}

function getFightData($id, $db)
{
  $query = "SELECT * FROM fight WHERE FightID = :id";
  $statement = $db->prepare($query);
  $statement->bindValue(':id', $id);
  $statement->execute();
  $foundFight = $statement->fetch();

  return $foundFight;
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