<?php

/*******************
* WEBD Final Project - addfighter page
* Name:     Mark Woods
* Date:     March 25, 2020
********************/

require 'functions.php';
require 'authenticate.php';

$pageTitle = "Sign up";

if (isset($_POST['email']))
{
    if (strcmp($_POST['pass'], $_POST['confirmpass']) != 0)
    {
        $message = "Your passwords did not match.";
    }
    else
    {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);

        $options = ['salt' => "WMMALSalt2020"];
        $hashedPass = password_hash($pass, PASSWORD_BCRYPT, $options);
    
        $query = "INSERT INTO user (Username, Password, Email)
                        VALUES(:username, :password, :email)";

        $statement = $db->prepare($query);
    
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', $hashedPass);
        $statement->bindValue(':email', $email);
    
        if ($statement->execute())
        {
            $message = "Successfully registered $username.";
        }
        else{
            $message = "Unable to register user. Error: " . $statement->errorCode();
        }
    }
}
else
{
    if (isset($_SESSION['message']))
    {
        $message = $_SESSION['message'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title><?= $pageTitle ?></title>
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
                <input id="username" name="username" type="text" required>              
            </li>
            <li>            
                <label for="email">Email:</label>
                <input id="email" name="email" type="email" required>              
            </li>
            <li>            
                <label for="pass">Password:</label>
                <input id="pass" name="pass" type="password" required>              
            </li>
            <li>            
                <label for="confirmpass">Confirm:</label>
                <input id="confirmpass" name="confirmpass" type="password" required>              
            </li>
            <li>
                <button>Register</button>
            </li>
          </ul>
        </fieldset>
      </form>
    </section>

    <footer>
    </footer>
</body>
</html>