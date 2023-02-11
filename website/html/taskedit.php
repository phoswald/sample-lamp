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
    header('Location: /task.php?taskid=' . $taskid, true, 301);
    exit;
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
  $dbstmt = mysqli_prepare($db, "SELECT USER_ID, TIMESTAMP, TITLE, DESCRIPTION, DONE FROM TASK WHERE TASK_ID=?");
  mysqli_stmt_bind_param($dbstmt, "s", $taskid);
  mysqli_stmt_execute($dbstmt);
  mysqli_stmt_bind_result($dbstmt, $userid, $timestamp, $title, $description, $done);
  mysqli_stmt_fetch($dbstmt) or die('Error querying database.');
  mysqli_stmt_close($dbstmt);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Edit Task Details</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="tasks.php">Tasks</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="">Details</a>
            </li>
          </ul>
        </div>  
      </div>
    </nav>
    <div class="container" style="max-width: 960px">
      <h2 class="my-4">Edit Task Details</h2>
      <p>
        <?php echo '<a class="btn btn-secondary btn-sm" href="task.php?taskid=' . htmlspecialchars($taskid) . '">Cancel</a>' ?>
      </p>
      <form action="#" method="post">
        <div class="mb-3">
          <label for="taskid" class="form-label">TaskId:</label>
          <?php echo '<input type="text" class="form-control" id="taskid" name="taskid" value="' . htmlspecialchars($taskid) . '" disabled>' ?>
        </div>
        <div class="mb-3">
          <label for="userid" class="form-label">UserId:</label>
          <?php echo '<input type="text" class="form-control" id="userid" name="userid" value="' . htmlspecialchars($userid) . '" disabled>' ?>
        </div>
        <div class="mb-3">
          <label for="timestamp" class="form-label">Updated:</label>
          <?php echo '<input type="text" class="form-control" id="timestamp" name="timestamp" value="' . htmlspecialchars($timestamp) . '" disabled>' ?>
        </div>
        <div class="mb-3">
          <label for="title" class="form-label">Title:</label>
          <?php echo '<input type="text" class="form-control" id="title" name="title" value="' . htmlspecialchars($title) . '">' ?>
        </div>
        <div class="mb-3">
          <label for="description" class="form-label">Description:</label>
          <textarea class="form-control" id="description" name="description" rows="5"><?php echo htmlspecialchars($description) ?></textarea>
        </div>
        <div class="mb-3 form-check">
          <?php echo '<input type="checkbox" class="form-check-input" id="done" name="done" ' . ($done == '1' ? 'checked' : '') . '>' ?>
          <label class="form-check-label" for="done">Done</label>
        </div>
        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-primary btn-sm" name="action" value="store">Store</button> 
          <button type="submit" class="btn btn-danger btn-sm" name="action" value="delete">Delete</button>
        </div>
      </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
<?php
  mysqli_close($db);
?>
