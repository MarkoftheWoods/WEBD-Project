<?php 
  /*******************
  * WEBD Final Project - login page
  * Name:     Mark Woods
  * Date:     April 9th, 2020
  ********************/ 

    require 'connect.php';

    if (isset($_POST['Username']))
    {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $user = validateLogon($username, $password, $db);
        
        if ( ($user != null) && ($user['Enabled'] == true) )
        {
            session_start();
            $_SESSION['User'] = $user;
        }
        elseif ( ($user != null) && ($user['Enabled'] == false) )
        {
            $message = 'Unable to sign in. Your account is disabled.';
        }
        else{
            $message = "Unable to sign in with that username/password combo.";
        }
    }

    if (isset($_SESSION['User']))
    {
        $signedIn = true;
    }
    else   
        $signedIn = false;

    
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Log in</title>
  <link rel="stylesheet" href="styles.css">
</head>
<?php if($signedin): ?>
    <body id='signinbody'>
    <?php if (isset($message)): ?>
        <p id="alert"><?= $message ?> </p>
      <?php endif ?>
        <form id='signinbox' method='post'>
            <fieldset>
                <ul>
                <li>
                    <label for='username'>Username: </label>
                    <input id='username' name='username' type='text'/>
                </li>
                <li>
                    <label for='password'>Password: </label>
                    <input id='password' name='password' type='password'/>
                </li>
                <li>
                    <button id='signinbutton'>Log in</button>
                    <a href='register.php'>Register</a>
                </li>
                </ul>
            </fieldset>
        </form>
    </body>
<?php else: ?>
    <body>
        <h2>You have been logged in as <?= $user['Username'] ?>. <a href='index.php'>Click here</a> to return to the homepage.</h2>
    </body>
<?php endif ?>
</html>