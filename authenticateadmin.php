<!-- 
  *******************
  * WEBD Final Project - AuthenticateAdmin page
  * Name:     Mark Woods
  * Date:     Arpil 15, 2020
  ******************** 
-->

<?php
    $validAdmin = false;

    if (isset($_SESSION['User']))
    {
      if ( ($_SESSION['User']['Enabled'] == true) && ($_SESSION['User']['Role'] == "ADMIN") )
      {
        $validAdmin = true;
      }
    }
    
    if (!$validAdmin)
    {
        exit("That feature is only available to administrators. <a href=index.php>Return to homepage.</a>");
    }
?>