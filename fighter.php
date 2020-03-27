<?php

/*******************
* WEBD Final Project - fighter page
* Name:     Mark Woods
* Date:     March 12, 2020
********************/

require 'header.php';

$fighterID = filter_input(INPUT_GET, 'fighterid', FILTER_VALIDATE_INT);
$fighterList = getAllFighters($db);

if ($fighterID != null)
{
  $fighter = getFighterData($fighterID, $db);

  $query = "SELECT * FROM fight WHERE RedCornerFighter = :fighterID OR BlueCornerFighter = :fighterID";
  $statement = $db->prepare($query);
  $statement->bindValue(':fighterID', $fighterID);
  $statement->execute();
  $fights = $statement->fetchAll();
}

function formatFight($fight, $fighter)
{
  if ($fight['RedCornerFighter'] == $fighter['FighterID'])
  {
    $thisFighter = $fight['RedCornerFighter'];
    $otherFighter = $fight['BlueCornerFighter'];
    $fighterResult = $fight['RedCornerResult'];    
  }
  else
  {
    $thisFighter = $fight['BlueCornerFighter'];
    $otherFighter = $fight['RedCornerFighter'];
    $fighterResult = $fight['BlueCornerResult'];  
  }
    $output = '<a href=\'fight.php?fightid=' || $fight['FightID'] || '>' || $fight['Result'] || ' vs ' || $otherFighter || '</a>';
    return $output; 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Fighter Profile</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
      <h1>Fighter Profile</h1>
      <p><a href='index.php'>Return to main page</a></p>
    </header>

    <section id='topnavbar'>
    <form method="get">
      <fieldset>
        <select id="fighterid" name="fighterid">
          <?php foreach ($fighterList as $listItem): ?>
            <option value='<?= $listItem['FighterID'] ?>'><?= $listItem['Name'] ?></option>
          <?php endforeach ?>
        </select>
        <button type="submit">Go</button>
      </fieldset>
    </form>
    </section>

    <?php if ($fighterID != null): ?>
      <section id='main'>
        <h2><?= $fighter['Name'] ?></h2><a id="editlink" href='addfighter.php?fighterid=<?= $fighterID ?>'>Edit</a>
        <p><?= $fighter['Wins']?>-<?= $fighter['Losses']?>-<?= $fighter['Draws']?>  (<?= $fighter['NoContests']?>)</p>
        <ul>
          <li>From: <?= $fighter['Birthplace'] ?></li>
          <li>Born: <?= $fighter['Birthdate'] ?></li>        
        </ul>

        <h3>Fights</h3>
        <?php if ($fights != null): ?>
        <ul>
          <?php foreach ($fights as $fight): ?>
              <li><?= formatFight($fight, $fighter) ?></li>
          <?php endforeach ?>
        </ul>
        <?php endif ?>
      </section>
    <?php endif ?>

    <footer>
    </footer>
</body>
</html>