<?php 
  /*******************
  * WEBD Final Project - login page
  * Name:     Mark Woods
  * Date:     April 9th, 2020
  ********************/ 

    require 'connect.php';

    if (isset($_SESSION))
    $signedIn = true;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Log in</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body id='signinbody'>
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
</html>