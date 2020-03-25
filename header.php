<?php
  /*******************
  * WEBD Final Project - Header page
  * Name:     Mark Woods
  * Date:     March 12, 2020
  ********************/ 

require 'connect.php';
//require 'authenticate.php';

function getFighterData($id, $db)
{

  $query = "SELECT * FROM fighter WHERE FighterID = :id";
  $statement = $db->prepare($query);
  $statement->bindValue(':id', $id);
  $statement->execute();
  $foundFighter = $statement->fetch();

  return $foundFighter;
}

?>