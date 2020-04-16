<?php

/*******************
* WEBD Final Project - edituser page
* Name:     Mark Woods
* Date:     April 15, 2020
********************/

require 'functions.php';
require 'authenticateadmin.php';

$pageTitle = "Edit User";


if (isset($_GET['userid']))
{
  $userID = filter_input(INPUT_GET, 'userid', FILTER_VALIDATE_INT);
  
  if ($userID != null)
  {
    $user = getUserData($userID, $db);
  }

  if (isset($_POST['username']))
  {
    $userName = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $enabled = false;

    if ($_POST['enabled'] == 'on')
        $enabled = true;

    $query = "UPDATE user SET Username = :username, Role = :role, Enabled = :enabled, Email = :email 
                    WHERE UserID = :id";
    $statement = $db->prepare($query);

    $statement->bindValue(':username', $userName);
    $statement->bindValue(':role', $role);
    $statement->bindValue(':enabled', $enabled);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':id', $user['UserID']);

    if ($statement->execute())
    {
      $message = "Successfully edited user.";
      $user = getUserData($user['UserID'], $db);
    }
    else{
      $message = "Unable to edit user. Error: " . $statement->errorCode();
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
  $user = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Edit user</title>
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
              <input id="username" name="username" type="text" value="<?= $user['Username'] ?>" required />             
            </li>
            <li>
              <label for="email">Email:</label>
              <input id="email" name="email" type="email" required value="<?= $user['Email'] ?>" />              
            </li>
            <li>
              <label for="role">Role:</label>
              <select id="role" name="role">
                <?php if ($user['Role'] == "ADMIN"): ?>
                    <option value='ADMIN' selected>ADMIN</option>
                    <option value='STAFF'>STAFF</option>
                <?php elseif ($user['Role'] == "STAFF"): ?>
                    <option value='ADMIN'>ADMIN</option>
                    <option value='STAFF' selected>STAFF</option>
                <?php else: ?>
                    <option value="" selected disabled hidden>Choose a role:</option>
                    <option value='ADMIN'>ADMIN</option>
                    <option value='STAFF'>STAFF</option>
                <?php endif ?>
              </select>            
            </li>
            <li>
                <label for="enabled">Enabled:</label>
                <?php if ($user['Enabled']): ?>
                    <input id="enabled" name="enabled" type="checkbox" checked />
                <?php else: ?>
                    <input id="enabled" name="enabled" type="checkbox" />
                <?php endif ?>
            </li>
            <li>
                <button formaction="edituser.php?userid=<?= $userID?>">Edit User</button>
                <button formaction="delete.php?userid=<?= $UserID?>">Delete User</button>
            </li>

          </ul>
        </fieldset>
      </form>
      <p><a href="users.php">Back to users list.</a></p>
    </section>

    <footer>
    </footer>
</body>
</html>