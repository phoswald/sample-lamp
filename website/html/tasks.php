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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Tasks Overview</title>
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
              <a class="nav-link active" href="">Tasks</a>
            </li>
          </ul>
        </div>  
      </div>
    </nav>
    <div class="container">
      <h2 class="my-4">Tasks Overview</h2>
      <form action="#" method="post">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Done</th>
              <th>Title</th>
              <th>Updated</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
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
                echo '  <div class="d-grid gap-2">';
                echo '    <a class="btn btn-secondary btn-sm" href="task.php?taskid=' . htmlspecialchars($taskid) . '">Details</a>';
                echo '  </div>';
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
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary btn-sm" name="action" value="create">Add</button>
                </div>  
              </td>
            </tr>      
          </tbody>
        </table>
      </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
<?php
  mysqli_close($db);
?>
