<!-- 
  *******************
  * WEBD Final Project - Authenticate page
  * Name:     Mark Woods
  * Date:     Arpil 15, 2020
  ******************** 
-->

<?php
    $validUser = false;

    if (isset($_SESSION['User']))
    {
      if ($_SESSION['User']['Enabled'] == true)
      {
        $validUser = true;
      }
    }
    
    if (!$validUser)
    {
        exit("That feature is only available to staff. <a href=login.php>Please log in.</a>");
    }
?>