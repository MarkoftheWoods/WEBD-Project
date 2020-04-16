<?php

/*******************
* WEBD Final Project - adduser page
* Name:     Mark Woods
* Date:     April 15, 2020
********************/

require 'functions.php';
require 'authenticateadmin.php';

  $pageTitle = "Add User";

  if (isset($_POST['username']))
  {
    $userName = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $confirmedPass = filter_input(INPUT_POST, 'confirmedpass', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
    
    $enabled = false;

    if ($pass != $confirmedPass)
    {
      $message = "Passwords do not match";
      $validData = false;
    }


    if ($_POST['enabled'] == 'on')
        $enabled = true;

    $query = "INSERT INTO user (Username, Password, Role, Enabled, Email)
                    VALUES(:username, :pass, :role, :enabled, :email)";
    $statement = $db->prepare($query);

    $statement->bindValue(':username', $userName);
    $statement->bindValue(':pass', $hashedPass);
    $statement->bindValue(':role', $role);
    $statement->bindValue(':enabled', $enabled);
    $statement->bindValue(':email', $email);

    if ($statement->execute())
    {
      $message = "Successfully added user.";
      $user = getUserData($user['UserID'], $db);
    }
    else{
      $message = "Unable to add user. Error: " . $statement->errorCode();
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Add user</title>
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
              <input id="username" name="username" type="text" required />             
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
              <label for="email">Email:</label>
              <input id="email" name="email" type="email" required />              
            </li>
            <li>
              <label for="role">Role:</label>
              <select id="role" name="role">
                    <option value="" selected disabled hidden>Choose a role:</option>
                    <option value='ADMIN'>ADMIN</option>
                    <option value='STAFF'>STAFF</option>
              </select>            
            </li>
            <li>
                <label for="enabled">Enabled:</label>
                <input id="enabled" name="enabled" type="checkbox" />
            </li>
            <li>
                <button formaction="adduser.php">Add User</button>
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