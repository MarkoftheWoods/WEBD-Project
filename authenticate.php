<!-- 
  *******************
  * WEBD Final Project - Authenticate page
  * Name:     Mark Woods
  * Date:     March 12, 2020
  ******************** 
-->

<?php
    define('ADMIN_LOGIN','admin');

    define('ADMIN_PASSWORD','mypass');

    if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])

    || ($_SERVER['PHP_AUTH_USER'] != ADMIN_LOGIN)

    || ($_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD)) 
    {

        header('HTTP/1.1 401 Unauthorized');

        header('WWW-Authenticate: Basic realm="WMMAL"');

        exit("Access Denied: Username and password required.");

    }
?>