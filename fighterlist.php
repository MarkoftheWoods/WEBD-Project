<?php 
  /*******************
  * WEBD Final Project - fighterlist page
  * Name:     Mark Woods
  * Date:     March 12, 2020
  ********************/ 

  require 'functions.php';

  $pageTitle = "Fighter list";

  if (isset($_GET['sortby']))
  {
    $sortBy = filter_input(INPUT_GET, 'sortby', FILTER_SANITIZE_STRING);

    $validColumns = ["FighterID", "FighterID DESC", "Name", "Birthdate", "Wins", "Losses", "Name DESC", "Birthdate DESC", "Wins DESC", "Losses DESC"];
    
    if (!in_array($sortBy, $validColumns))
    {
      $sortBy = "FighterID";
    }

    $query = "SELECT * FROM fighter ORDER BY $sortBy";
    $statement = $db->prepare($query);
    $statement->execute();
    $sortedList = $statement->fetchAll();

    echo $query;
  }
  else
  {
    $sortedList = getAllFighters($db);
  }    
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>WMMAL Fighter Directory</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
      <?php require 'header.php'; ?>
    </header>  

    <section>
    <?php if (isset($message)): ?>
        <p id="alert"><?= $message ?> </p>
    <?php endif ?>
    <h3>Full Fighter List</h3>
    <form method="get">
        <ul><li>
            <label for="sortby">Sort by:</label>
            <select name="sortby">
              <option hidden selected disabled>Select an item</option>
              <option value='Name'>Name (alphabetical)</option>
              <option value='Name DESC'>Name (reverse)</option>
              <option value='Birthdate'>Birthdate (ascending)</option>
              <option value='Birthdate DESC'>Birthdate (descending)</option>
              <option value='Wins'>Wins (ascending)</option>
              <option value='Wins DESC'>Wins (descending)</option>
              <option value='Losses'>Losses (ascending)</option>
              <option value='Losses DESC'>Losses (descending)</option>
              <option value='FighterID'>Date Added (ascending)</option>
              <option value='FighterID DESC'>Date Added (descending)</option>
            </select>
            <button type="submit">Go</button>
        </li></ul>
    </form>

    <table>
        <tr>
            <th>Name</th>
            <th>Birthplace</th>
            <th>Birthdate</th>
            <th>W</th>
            <th>L</th>
            <th>D</th>
            <th>NC</th>
            <?php if (isset($_SESSION['User'])): ?>
              <th></th>
            <?php endif ?>
        </tr>
      <?php foreach ($sortedList as $listItem): ?>
        <tr>
            <td><?= $listItem['Name'] ?></td>
            <td><?= $listItem['Birthplace'] ?></td>
            <td><?= $listItem['Birthdate'] ?></td>
            <td><?= $listItem['Wins'] ?></td>
            <td><?= $listItem['Losses'] ?></td>
            <td><?= $listItem['Draws'] ?></td>
            <td><?= $listItem['NoContests'] ?></td>
          <?php if (isset($_SESSION['User'])): ?>
            <td><a href='addfighter.php?fighterid=<?= $listItem['FighterID'] ?>'>Edit</a></td>
          <?php endif ?>    
        </tr>
      <?php endforeach ?>
    </section>
</body>
</html>