<?php
  $dbhost = 'sample-mariadb:3306';
  $dbuser = 'sample';
  $dbpass = 'sesam';
  $dbname = 'sample';
  $db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Error connecting to MySQL server.');
?>
<?php
  if($_POST["action"] == "create") {
    $title = $_POST["title"];
    $dbstmt = mysqli_prepare($db, "INSERT INTO TASK (TASK_ID, USER_ID, TIMESTAMP, TITLE) SELECT UUID(), 'guest', CURRENT_TIMESTAMP(), ?");
    mysqli_stmt_bind_param($dbstmt, "s", $title);
    mysqli_stmt_execute($dbstmt) or die('Error inserting into database.');
    mysqli_stmt_close($dbstmt);
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title>Tasks Overview</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="/">Home</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="#">Tasks</a>
        </li>
      </ul>
    </nav>
    <div class="container">
      <h2 class="my-4">Tasks Overview</h2>
      <form action="#" method="post">
        <table class="table table-hover mt-4">
          <tr>
            <th>Done</th>
            <th>Title</th>
            <th>Updated</th>
            <th></th>
          </tr>
          <?php
            $dbstmt = mysqli_prepare($db, "SELECT TASK_ID, TIMESTAMP, TITLE, DONE FROM TASK ORDER BY TIMESTAMP DESC");
            mysqli_stmt_execute($dbstmt);
            mysqli_stmt_bind_result($dbstmt, $taskid, $timestamp, $title, $done);
            while (mysqli_stmt_fetch($dbstmt)) {
              echo '<tr>';
              echo '<td>';
              echo '  <input type="checkbox" name="done" ' . ($done == '1' ? 'checked' : '') . ' disabled>';
              echo '</td>';
              echo '<td>' . htmlspecialchars($title) . '</td>';
              echo '<td>' . htmlspecialchars($timestamp) . '</td>';
              echo '<td>';
              echo '  <a class="btn btn-secondary btn-sm btn-block" href="task.php?taskid=' . htmlspecialchars($taskid) . '">Details</a>';
              echo '</td>';
              echo '</tr>';
            }
            mysqli_stmt_close($dbstmt);
          ?>
          <tr>
            <td></td>
            <td><input type="text" class="form-control" name="title" value="New task..."></td>
            <td></td>
            <td>
              <button type="submit" class="btn btn-primary btn-sm btn-block" name="action" value="create">Add</button>
            </td>
          </tr>      
        </table>
      </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
  </body>
</html>
<?php
  mysqli_close($db);
?>
