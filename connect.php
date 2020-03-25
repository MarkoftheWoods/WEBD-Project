<?php
/*******************
* WEBD Final Project - DB connection page
* Name:     Mark Woods
* Date:     March 12, 2020
********************/

    define('DB_DSN','mysql:host=localhost;dbname=wmmal;charset=utf8');
    define('DB_USER','dbadmin');
    define('DB_PASS','gorgonzola7!');     

    $db = new PDO(DB_DSN, DB_USER, DB_PASS);
?>