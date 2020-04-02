<?php
 /*
    Header page. Data is inserted into every other page.
 */

?>


<section>
    <ul id='topnavbar'>
        <li><a href='index.php'>Home</a></li>
        <?php if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) || ($_SERVER['PHP_AUTH_USER'] != ADMIN_LOGIN) || ($_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD)):  ?>
            <li><a href='authenticate.php'>Login</a></li>
        <?php else: ?>
            <li><a href='logout.php'>Logout</a></li>
        <?php endif ?>
    </ul>
    
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

    <h1><?= $pageTitle ?></h1>
    
</section>