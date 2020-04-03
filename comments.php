<?php
 /*
    Comments page. Data is inserted into every fighter and fight page.
 */

if ($pageTitle == "Fighter Profile")
{
  $commentType = "FighterID";
  $pageID = $fighterID;
}

if (isset($_POST['commentusername']))
{
  $commentusername = filter_input(INPUT_POST, 'commentusername', FILTER_SANITIZE_STRING);
  $commenttext = filter_input(INPUT_POST, 'commenttext', FILTER_SANITIZE_STRING);
  
  if ( ($commentusername != null) && ($commenttext != null) )
  {
    $commentinsert = "INSERT INTO `comment` (`UserID`, `Text`, `$commentType`) 
                  VALUES (:commentusername, :commenttext, :pageID)";
    $statement = $db->prepare($commentinsert);

    $statement->bindValue(':commentusername', $commentusername);
    $statement->bindValue(':commenttext', $commenttext);
    $statement->bindValue(':pageID', $pageID);

    if ($statement->execute())
    {
      $commentfeedback = "Successfully added comment.";
    }
    else
    {
      $commentfeedback = "Unable to add comment. Error: " . $statement->errorCode();
    }
  }
}

$commentQuery = "SELECT * FROM comment WHERE $commentType = :id ORDER BY CommentDate DESC";
$statement = $db->prepare($commentQuery);
$statement->bindValue(':id', $pageID);
$statement->execute();
$pageComments = $statement->fetchAll();

?>

<section>
    <h2>Comments</h2>
    
    <?php if (isset($commentfeedback)): ?>
      <p id="alert"><?= $commentfeedback ?> </p>
    <?php endif ?>

    <form method="post" id="commentform">
      <fieldset>
        <ul>
          <li>
            <label for="commentusername">User: </label>
            <input id="commentusername" name="commentusername" type="text" required></input>
          </li>
          <li>
            <label for="commenttext">Comment: </label>
            <textarea id="commenttext" name="commenttext" required></textarea>
          </li>
          <li>
            <button id="submitcomment">Submit</button>
          </li>
        </ul>
      </fieldset>
    </form>

    <ul id='commentlist'>
    <?php foreach ($pageComments as $comment): ?>
      <li>
        <ul id='comment'>
          <li id='userline'><span><?= $comment['UserID'] ?></span><span><a id='editlink' href='editcomment.php?commentid=<?= $comment['CommentID']?>'>[Edit]</a></span></li>
          <li><?= $comment['CommentDate'] ?></li>
          <li><?= $comment['Text'] ?></li>
        </ul>
      </li>
    <?php endforeach ?>
    </ul>
    
</section>