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

?>