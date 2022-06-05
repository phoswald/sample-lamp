<!doctype html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>sample-lamp</title>
</head>

<body>
  <h1>sample-php (PHP)</h1>
  <p>
    <?php echo "Die aktuelle Zeit ist " . date("Y/m/d H:i:s") . " (UTC)."; ?>
  </p>
  <h2>Datenbank</h2>
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
  <table>
    <tr>
      <th>Key</th>
      <th>Value</th>
    </tr>
    <?php
       $db = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to MySQL server.');
       $sql = "SELECT sample_key, sample_val FROM sample.sample_table";
       mysqli_query($db, $sql) or die('Error querying database.');
       $result = mysqli_query($db, $sql);
       while ($row = mysqli_fetch_array($result)) {
         echo '<tr><td>' . $row['sample_key'] . '</td><td>' . $row['sample_val'] . '</td></tr>';
       }
       mysqli_close($db);
    ?>
  </table>
</body>