<?php

/*******************
* WEBD Final Project - resetpassword page
* Name:     Mark Woods
* Date:     April 16, 2020
********************/

require 'functions.php';
require 'authenticate.php';

$pageTitle = "Reset Password";

if (isset($_GET['userid']))
{
  $userID = filter_input(INPUT_GET, 'userid', FILTER_VALIDATE_INT);
  
  if ($userID != null)
  {
    $userToChange = getUserData($userID, $db);
  }

  if ( ($_SESSION['User']['Role'] == "ADMIN") || ($_SESSION['User']['UserID'] == $userToChange['UserID']) )
  {
      if (isset($_POST['pass']))
      {
        $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
        $confirmedPass = filter_input(INPUT_POST, 'passconfirmed', FILTER_SANITIZE_STRING);

        if ($pass == $confirmedPass)
        {
          $hashedPass = password_hash($pass, PASSWORD_BCRYPT);

          $query = "UPDATE user SET Password = :pass 
                          WHERE UserID = :id";
          $statement = $db->prepare($query);

          $statement->bindValue(':pass', $hashedPass);
          $statement->bindValue(':id', $userToChange['UserID']);

          if ($statement->execute())
          {
            $message = "Successfully reset password for " . $userToChange['Username'] . ".";
            $userToChange = getUserData($userToChange['UserID'], $db);
          }
          else
          {
            $message = "Unable to reset password. Error: " . $statement->errorCode();
          }
        }
        else
        {
          $message =  "Error: The supplied passwords don't match.   '" . $pass . "' vs '" . $confirmedPass . "'";
        }
      }
  }
  else
  {
    $message = "Your role does not allow you to change passwords for other users.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Reset Password</title>
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
              <label for="username">Username:</label>
              <input id="username" name="username" type="text" value="<?= $userToChange['Username'] ?>" disabled />             
            </li>
            <li>
              <label for="pass">Password:</label>
              <input id="pass" name="pass" type="password" required />           
            </li>
            <li>
              <label for="passconfirmed">Confirm Password:</label>
              <input id="passconfirmed" name="passconfirmed" type="password" required />           
            </li>
            <li>
              <button formaction="resetpassword.php?userid=<?= $userToChange['UserID'] ?>">Reset Password</button>
            </li>
          </ul>
        </fieldset>
      </form>
    </section>

    <footer>
    </footer>
</body>
</html>