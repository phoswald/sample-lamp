<?php
  $dbhost = 'sample-mariadb:3306';
  $dbuser = 'sample';
  $dbpass = 'sesam';
  $dbname = 'sample';
  $db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Error connecting to MySQL server.');
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
    <title>Task Details</title>
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
      <h2 class="my-4">Task Details</h2>
      <p>
        <?php echo '<a class="btn btn-secondary btn-sm" href="taskedit.php?taskid=' . htmlspecialchars($taskid) . '">Edit</a>' ?>
      </p>
      <table class="table">
        <tbody>
          <tr>
            <th scope="row">TaskId</th>
            <td><?php echo htmlspecialchars($taskid) ?></td>
          </tr>
          <tr>
            <th scope="row">UserId</th>
            <td><?php echo htmlspecialchars($userid) ?></td>
          </tr>
          <tr>
            <th scope="row">Updated</th>
            <td><?php echo htmlspecialchars($timestamp) ?></td>
          </tr>
          <tr>
            <th scope="row">Title</th>
            <td><?php echo htmlspecialchars($title) ?></td>
          </tr>
          <tr>
            <th scope="row">Description</th>
            <td><pre><?php echo htmlspecialchars($description) ?></pre></td>
          </tr>
          <tr>
            <th scope="row"></th>
            <td><?php echo '<input type="checkbox" name="done" ' . ($done == '1' ? 'checked' : '') . ' disabled>' ?> Done</td>
          </tr>
        </tbody>
      </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
<?php
  mysqli_close($db);
?>
