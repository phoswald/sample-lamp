<?php
  $dbhost = 'sample-mariadb:3306';
  $dbuser = 'sample';
  $dbpass = 'sesam';
  $dbname = 'sample';
  $db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Error connecting to MySQL server.');
?>
<?php
  if($_POST["action"] == "store") {
    $taskid = $_GET["taskid"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $done = $_POST["done"] == "on" ? 1 : 0;
    $dbstmt = mysqli_prepare($db, "UPDATE TASK SET TIMESTAMP=CURRENT_TIMESTAMP(), TITLE=?, DESCRIPTION=?, DONE=? WHERE TASK_ID=?");
    mysqli_stmt_bind_param($dbstmt, "ssis", $title, $description, $done, $taskid);
    mysqli_stmt_execute($dbstmt) or die('Error updating database.');
    mysqli_stmt_close($dbstmt);
  }
  if($_POST["action"] == "delete") {
    $taskid = $_GET["taskid"];
    $dbstmt = mysqli_prepare($db, "DELETE FROM TASK WHERE TASK_ID=?");
    mysqli_stmt_bind_param($dbstmt, "s", $taskid);
    mysqli_stmt_execute($dbstmt) or die('Error deleting from database.');
    mysqli_stmt_close($dbstmt);
    header('Location: /tasks.php', true, 301);
    exit;
  }
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
    <title>Edit Task Details</title>
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
      <h2 class="my-4">Edit Task Details</h2>
      <p>
        <?php echo '<a class="btn btn-secondary btn-sm" href="task.php?taskid=' . htmlspecialchars($taskid) . '">Cancel</a>' ?>
      </p>
      <form action="#" method="post">
        <div class="form-group mt-4">
          <label for="id">ID:</label>
          <?php echo '<input type="text" class="form-control" id="id" name="id" value="' . htmlspecialchars($taskid) . '" disabled>' ?>
        </div>
        <div class="form-group">
          <label for="timestamp">Updated:</label>
          <?php echo '<input type="text" class="form-control" id="timestamp" name="timestamp" value="' . htmlspecialchars($timestamp) . '" disabled>' ?>
        </div>
        <div class="form-group">
          <label for="title">Title:</label>
          <?php echo '<input type="text" class="form-control" id="title" name="title" value="' . htmlspecialchars($title) . '">' ?>
        </div>
        <div class="form-group">
          <label for="description">Description:</label>
          <textarea class="form-control" id="description" name="description" rows="5"><?php echo htmlspecialchars($description) ?></textarea>
        </div>
        <div class="form-group custom-control">
          <?php echo '<input type="checkbox" class="custom-control-input" id="done" name="done" ' . ($done == '1' ? 'checked' : '') . '>' ?>
          <label class="custom-control-label" for="done">Done</label>
        </div>
        <p>
          <button type="submit" class="btn btn-primary btn-sm btn-block" name="action" value="store">Store</button> 
          <button type="submit" class="btn btn-danger btn-sm btn-block" name="action" value="delete">Delete</button>
        </p>
      </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
  </body>
</html>
<?php
  mysqli_close($db);
?>
