<?php

/*******************
* WEBD Final Project - addfighter page
* Name:     Mark Woods
* Date:     March 25, 2020
********************/

require 'functions.php';

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

if (isset($_GET['commentid']))
{
    $commentID = filter_input(INPUT_GET, 'commentid', FILTER_VALIDATE_INT);

    $comment = getCommentData($commentID, $db);
    $_SESSION['message'] = "Successfully deleted comment.";

    $query = "DELETE FROM comment WHERE CommentID = :commentid";
    $statement = $db->prepare($query);
    $statement->bindValue(':commentid', $commentID, PDO::PARAM_INT);
    $statement->execute();

    header('Location: index.php');
    exit;
}

if (isset($_GET['eventid']))
{
    $eventID = filter_input(INPUT_GET, 'eventid', FILTER_VALIDATE_INT);

    $event = getEventData($eventID, $db);
    $_SESSION['message'] = "Successfully deleted event.";

    $query = "DELETE FROM event WHERE EventID = :eventid";
    $statement = $db->prepare($query);
    $statement->bindValue(':eventid', $eventID, PDO::PARAM_INT);
    $statement->execute();

    header('Location: index.php');
    exit;
}

?>