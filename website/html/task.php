<?php
  $dbhost = 'sample-mariadb:3306';
  $dbuser = 'sample';
  $dbpass = 'sesam';
  $dbname = 'sample';
  $db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Error connecting to MySQL server.');
?>
<?php
  $taskid = $_GET["taskid"];
  $dbstmt = mysqli_prepare($db, "SELECT TIMESTAMP, TITLE, DESCRIPTION, DONE, USER_ID FROM TASK WHERE TASK_ID=?");
  mysqli_stmt_bind_param($dbstmt, "s", $taskid);
  mysqli_stmt_execute($dbstmt);
  mysqli_stmt_bind_result($dbstmt, $timestamp, $title, $description, $done, $userid);
  mysqli_stmt_fetch($dbstmt) or die('Error querying database.');
  mysqli_stmt_close($dbstmt);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title>Task Details</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="tasks.php">Tasks</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="#">Details</a>
        </li>
      </ul>
    </nav>
    <div class="container" style="max-width: 960px">
      <h2 class="my-4">Task Details</h2>
      <p>
        <?php echo '<a class="btn btn-secondary btn-sm" href="taskedit.php?taskid=' . htmlspecialchars($taskid) . '">Edit</a>' ?>
      </p>
      <table class="table my-4">
        <tr>
          <th>ID</th>
          <td><?php echo htmlspecialchars($taskid) ?></td>
        </tr>
        <tr>
          <th>Updated</th>
          <td><?php echo htmlspecialchars($timestamp) ?></td>
        </tr>
        <tr>
          <th>Title</th>
          <td><?php echo htmlspecialchars($title) ?></td>
        </tr>
        <tr>
          <th>Description</th>
          <td><pre><?php echo htmlspecialchars($description) ?></pre></td>
        </tr>
        <tr>
          <th></th>
          <td><?php echo '<input type="checkbox" name="done" ' . ($done == '1' ? 'checked' : '') . ' disabled>' ?>Done</td>
        </tr>
      </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
  </body>
</html>
<?php
  mysqli_close($db);
?>
