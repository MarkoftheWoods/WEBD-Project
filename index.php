<?php 
  /*******************
  * WEBD Final Project - index page
  * Name:     Mark Woods
  * Date:     March 12, 2020
  ********************/ 
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

    <section>
      <ul>
        <li><a href='fighterlist.php'>Fighter Directory</a></li>
        <li><a href='addfighter.php'>Add fighter</a></li>        
        <li><a href='addfight.php'>Add fight</a></li>
        <li><a href='addevent.php'>Add event</a></li>        
      </ul>
    </section>    

    <section>
         
    <?php if (isset($message)): ?>
        <p id="alert"><?= $message ?> </p>
    <?php endif ?>
    <form>
        <fieldset>
          <h3>Fighter List</h3>
          <div id='search'>
            <?php if (isset($message)): ?>
              <p id="alert"><?= $message ?> </p>
            <?php endif ?>

            <form method="get">
              <fieldset>
                <label for="search">Search:</label>
                <input type="text" name="search">
                <button type="submit">Go</button>
              </fieldset>
            </form>
          </div> 
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