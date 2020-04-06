<?php 
  /*******************
  * WEBD Final Project - index page
  * Name:     Mark Woods
  * Date:     March 12, 2020
  ********************/ 

  session_start();
  require 'functions.php';

  $pageTitle = "Index";

  if (isset($_GET['search']))
  {
    $search = '%' . strtoupper(filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING)) . '%';

    $query = "SELECT * FROM fighter WHERE UPPER(Name) LIKE :search";
    $statement = $db->prepare($query);
    $statement->bindValue(':search', $search);
    $statement->execute();
    $searchList = $statement->fetchAll();
  }
  else
  {
    $searchList = $fighterList;
  }

  if (isset($_SESSION['message']))
  {
    $message = $_SESSION['message'];
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>WMMAL Home</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
      <?php require 'header.php'; ?>
    </header>

    <section id='search'>
      <form method="get">
        <fieldset>
          <input type="text" name="search">
          <button type="submit">Go</button>
        </fieldset>
      </form>
    </section>

    <section>
      <a href='addfighter.php'>Add fighter</a>
      <a href='addfight.php'>Add fight</a>
      <a href='addevent.php'>Add event</a>
      <!--
      <ul>
        <li><a href='addfighter.php'>Add fighter</a></li>        
        <li><a href='addfight.php'>Add fight</a></li>
        <li><a href='addevent.php'>Add event</a></li>        
      </ul>
      -->
    </section>

    

    <section>
    <?php if (isset($message)): ?>
        <p id="alert"><?= $message ?> </p>
    <?php endif ?>
    <form>
      <fieldset>
      <h3>Fighter List</h3>
        <ul>
          <?php foreach ($searchList as $listItem): ?>
            <li>
              <a href="fighter.php?fighterid=<?= $listItem['FighterID'] ?>" ><?= $listItem['Name'] ?></a>
            </li>
          <?php endforeach ?>
        </ul>
      </fieldset>
    </form>
    </section>
</body>
</html>