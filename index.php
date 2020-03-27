<?php 
  /*******************
  * WEBD Final Project - index page
  * Name:     Mark Woods
  * Date:     March 12, 2020
  ********************/ 

  session_start();
  require 'header.php';

  $fighterList = getAllFighters($db);

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
    <h1></h1>
    </header>

    <section id='topnavbar'>
      <form method="get" action="fighter.php">
        <fieldset>
          <select id="fighterid" name="fighterid">
            <?php foreach ($fighterList as $listItem): ?>
              <option value='<?= $listItem['FighterID'] ?>'><?= $listItem['Name'] ?></option>
            <?php endforeach ?>
          </select>
          <button type="submit" >Go</button>
        </fieldset>
      </form>
    </section>

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
      <!--
      <ul>
        <li><a href='addfighter.php'>Add fighter</a></li>        
        <li><a href='addfight.php'>Add fight</a></li>
        <li><a href='addevent.php'>Add event</a></li>        
      </ul>
      -->
    </section>

    <section>
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