<?php
  /*******************
  * WEBD Final Project - Functions page
  * Name:     Mark Woods
  * Date:     March 12, 2020
  ********************/ 

require 'connect.php';

$fighterList = getAllFighters($db);

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

function formatFight($fight, $fighter, $db)
{
  if ($fight['RedCornerFighter'] == $fighter['FighterID'])
  {
    $otherFighter = getFighterData($fight['BlueCornerFighter'], $db);
    $fighterResult = $fight['RedCornerResult'];    
  }
  else
  {
    $otherFighter = getFighterData($fight['RedCornerFighter'], $db);
    $fighterResult = $fight['BlueCornerResult'];  
  }
    $output = "<a href='fight.php?fightid=" . $fight['FightID'] . "'>" . $fighterResult . " vs " . $otherFighter['Name'] . "</a>";

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

?>