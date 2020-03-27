<?php

/*******************
* WEBD Final Project - addfighter page
* Name:     Mark Woods
* Date:     March 25, 2020
********************/

require 'header.php';

if (isset($_GET['fighterid']))
{
    $fighterID = filter_input(INPUT_GET, 'fighterid', FILTER_VALIDATE_INT);

    $fighter = getFighterData($fighterID, $db);
    $_SESSION['message'] = "Successfully deleted " || $fighter['Name'];

    $query = "DELETE FROM fighter WHERE FighterID = :fighterid";
    $statement = $db->prepare($query);
    $statement->bindValue(':fighterid', $fighterID, PDO::PARAM_INT);
    $statement->execute();

    header('Location: addfighter.php');
    exit;
}

?>