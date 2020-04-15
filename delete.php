<?php

/*******************
* WEBD Final Project - addfighter page
* Name:     Mark Woods
* Date:     March 25, 2020
********************/

require 'functions.php';
require 'authenticate.php';

if (isset($_GET['fighterid']))
{
    $fighterID = filter_input(INPUT_GET, 'fighterid', FILTER_VALIDATE_INT);
    $fighter = getFighterData($fighterID, $db);

    $imageURL = getImageURL($fighterID, $db);
    unlink("images/" . $imageURL);

    
    $_SESSION['message'] = "Successfully deleted " || $fighter['Name'];

    $query = "DELETE FROM fighter WHERE FighterID = :fighterid";
    $statement = $db->prepare($query);
    $statement->bindValue(':fighterid', $fighterID, PDO::PARAM_INT);
    $statement->execute();

    $query = "DELETE FROM image WHERE FighterID = :fighterid";
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

if (isset($_GET['userid']))
{
    $userID = filter_input(INPUT_GET, 'userid', FILTER_VALIDATE_INT);
    $userID = getUserData($userID, $db);

    
    $_SESSION['message'] = "Successfully deleted " || $user['Name'];

    $query = "DELETE FROM user WHERE UserID = :userid";
    $statement = $db->prepare($query);
    $statement->bindValue(':userid', $userID, PDO::PARAM_INT);
    $statement->execute(); 

    header('Location: userss.php');
    exit;
}

?>