<?php
 /*
    Header page. Data is inserted into every page.
 */

if (isset($_SESSION['User']))
{
  if ($_SESSION['User']['Role'] == "ADMIN")
    $adminUser = true;
}

?>

<section>
    <ul id='topnavbar'>
        
        <?php if (!isset($_SESSION['User'])):  ?>
            <li><a href='index.php'>Home</a></li>
            <li><a href='login.php'>Login</a></li>
            <li><a href='register.php'>Register</a></li>
        <?php else: ?>
            <li>Welcome: <?= $_SESSION['User']['Username'] ?></li>
            <li><a href='index.php'>Home</a></li>
            <?php if (isset($adminUser)): ?>
              <li><a href="users.php">Manage users</a></li>
            <?php endif ?>
            <li><a href='resetpassword.php?userid=<?= $_SESSION['User']['UserID'] ?>'>Reset Password</a></li>
            <li><a href='logout.php'>Logout</a></li>
        <?php endif ?>
    </ul>
    
    <form method="get" action="fighter.php">
        <fieldset>
          <select id="fighterlist" name="fighterid">
            <option value="" selected disabled hidden>Choose a fighter:</option>
            <?php foreach ($fighterList as $listItem): ?>
              <option value='<?= $listItem['FighterID'] ?>'><?= $listItem['Name'] ?></option>
            <?php endforeach ?>
          </select>
          <button type="submit" >Go</button>
        </fieldset>
    </form>

    <form method="get" action="event.php">
        <fieldset>
          <select id="eventlist" name="eventid">
            <option value="" selected disabled hidden>Choose an event:</option>
            <?php foreach ($eventList as $listItem): ?>
              <option value='<?= $listItem['EventID'] ?>'><?= $listItem['EventName'] ?></option>
            <?php endforeach ?>
          </select>
          <button type="submit" >Go</button>
        </fieldset>
    </form>
    <h1><?= $pageTitle ?></h1>
    
</section>