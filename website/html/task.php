<?php
  $dbhost = 'sample-mariadb:3306';
  $dbuser = 'sample';
  $dbpass = 'sesam';
  $db = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to MySQL server.');
?>
<?php
  $taskid = $_GET["taskid"];
  $sql = "SELECT TASK_ID, DESCRIPTION, DONE, TIMESTAMP, TITLE, USER_ID ". 
         "FROM sample.TASK WHERE TASK_ID='" . $taskid . "'";
  $result = mysqli_query($db, $sql);
  $row = mysqli_fetch_array($result);
  $timestamp = $row['TIMESTAMP'];
  $title = $row['TITLE'];
  $description = $row['DESCRIPTION'];
  $checked = ($row['DONE'] == '1' ? 'checked' : '');
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
        <?php echo '<a class="btn btn-secondary btn-sm" href="taskedit.php?taskid=' . $taskid . '">Edit</a>' ?>
      </p>
      <table class="table my-4">
        <tr>
          <th>ID</th>
          <td><?php echo $taskid ?></td>
        </tr>
        <tr>
          <th>Updated</th>
          <td><?php echo $timestamp ?></td>
        </tr>
        <tr>
          <th>Title</th>
          <td><?php echo $title ?></td>
        </tr>
        <tr>
          <th>Description</th>
          <td><pre><?php echo $description ?></pre></td>
        </tr>
        <tr>
          <th></th>
          <td><?php echo '<input type="checkbox" name="done" ' . $checked . ' disabled>' ?>Done</td>
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
