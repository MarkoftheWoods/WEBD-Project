<?php 
  /*******************
  * WEBD Final Project - users page
  * Name:     Mark Woods
  * Date:     March 12, 2020
  ********************/
  require 'functions.php';

  $allUsers = getAllUsers($db);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>WMMAL Users</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
      <h1>Manage Users</h1>
    </header>

    <section>
        <table id='usertable'>
          <tr>
            <th></th><th>UserID</th><th>Username</th><th>Email</th><th>Role</th><th>Date Created</th><th>Enabled</th>
            <?php foreach ($allUsers as $userListItem): ?>
              <tr>
                <td><a href='edituser.php?userid=<?= $userListItem['UserID'] ?>'>[Edit]</a></td>
                <td><?= $userListItem['UserID'] ?></td>
                <td><?= $userListItem['Username'] ?></td>
                <td><?= $userListItem['Email'] ?></td>
                <td><?= $userListItem['Role'] ?></td>
                <td><?= $userListItem['DateCreated'] ?></td>
                <td>
                  <?php if ($userListItem['Enabled'] == true): ?>
                    <input id='enabled' name='enabled' type='checkbox' checked disabled/>
                  <?php else: ?>
                    <input id='enabled' name='enabled' type='checkbox' disabled/>
                  <?php endif ?>
                </td>
                <td></td>
              </tr>
            <?php endforeach ?>
          </tr>

        </table>
    </section>
</body>
</html>