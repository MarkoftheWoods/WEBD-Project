<?php

/*******************
* WEBD Final Project - addfighter page
* Name:     Mark Woods
* Date:     March 25, 2020
********************/

require 'functions.php';
require 'authenticate.php';

$pageTitle = "Edit Comment";


if (isset($_GET['commentid']))
{
  $commentID = filter_input(INPUT_GET, 'commentid', FILTER_VALIDATE_INT);
  
  if ($commentID != null)
  {
    $comment = getCommentData($commentID, $db);
  }

  if (isset($_POST['commentuser']))
  {
    $commentUser = filter_input(INPUT_POST, 'commentuser', FILTER_SANITIZE_STRING);
    $commentText = filter_input(INPUT_POST, 'commenttext', FILTER_SANITIZE_STRING);

    $query = "UPDATE comment SET UserID = :userid, Text = :commenttext 
                    WHERE CommentID = :id";
    $statement = $db->prepare($query);

    $statement->bindValue(':userid', $commentUser);
    $statement->bindValue(':commenttext', $commentText);
    $statement->bindValue(':id', $comment['CommentID']);

    if ($statement->execute())
    {
      $message = "Successfully edited comment.";
    }
    else{
      $message = "Unable to edit comment. Error: " . $statement->errorCode();
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
else
{
  $comment = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Edit comment</title>
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
      
      <form method="post">
        <fieldset>
          <ul>
            <li>
              <label for="commentuser">Username:</label>
              <input id="commentuser" name="commentuser" type="text" value="<?= $comment['UserID'] ?>" required>             
            </li>
            <li>
              <label for="commenttext">Comment:</label>
              <textarea id="commenttext" name="commenttext" required><?= $comment['Text'] ?></textarea>
              
            </li>
            <li>
                <button formaction="editcomment.php?commentid=<?= $commentID?>">Edit comment</button>
                <button formaction="delete.php?commentid=<?= $commentID?>">Delete comment</button>
            </li>

          </ul>
        </fieldset>
      </form>
    </section>

    <footer>
    </footer>
</body>
</html>