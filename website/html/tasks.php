<!doctype html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<title>Tasks Overview</title>
</head>

<body>
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="../..">Home</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="">Tasks</a>
      </li>
    </ul>
  </nav>
  <div class="container">
    <h2 class="my-4">Tasks Overview</h2>
    <?php
      $dbhost = 'sample-mariadb:3306';
      $dbuser = 'sample';
      $dbpass = 'sesam';
    ?>
    <?php
      if($_GET["command"] == "insert") {
        $key = $_GET["key"];
        $val = $_GET["val"];
        $db = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to MySQL server.');
        $sql = "INSERT INTO sample.sample_table (sample_key, sample_val) VALUES ('" . $key . "', '" . $val . "')";
        mysqli_query($db, $sql) or die('Error inserting into database.');
        mysqli_close($db);
      }
    ?>
    <form action="tasks" method="post">
      <table class="table table-hover mt-4">
        <tr>
          <th>Done</th>
          <th>Title</th>
          <th>Updated</th>
          <th></th>
        </tr>
        <?php
          $db = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to MySQL server.');
          $sql = "SELECT TASK_ID, DESCRIPTION, DONE, TIMESTAMP, TITLE, USER_ID FROM sample.TASK";
          mysqli_query($db, $sql) or die('Error querying database.');
          $result = mysqli_query($db, $sql);
          while ($row = mysqli_fetch_array($result)) {
            echo '<tr>';
            echo '<td>';
            echo '  <input type="checkbox" name="done" checked="' . ($row['DONE'] == '1' ? 'checked' : '') . '" disabled="disabled">';
            echo '</td>';
            echo '<td>' . $row['TITLE'] . '</td>';
            echo '<td>' . $row['TIMESTAMP'] . '</td>';
            echo '<td>';
            echo '  <a class="btn btn-secondary btn-sm btn-block" href="tasks/' . $row['TASK_ID'] . '">Details</a>';
            echo '</td>';
            echo '</tr>';
          }
          mysqli_close($db);
        ?>
        <tr>
          <td></td>
          <td><input type="text" class="form-control" name="title" value="New task..."></td>
          <td></td>
          <td><input type="submit" class="btn btn-primary btn-sm btn-block" value="Add"></td>
        </tr>      
      </table>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"></script>
</body>
