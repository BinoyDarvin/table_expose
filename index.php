<?php


//dsn setup
$host = 'localhost';
$dbname = 'login_engine';
$username = 'root';
$password = '';

//creating global $con


//generating dsn
$dsn = "mysql:host=$host;dbname=$dbname";

$con = new PDO($dsn, $username, $password);
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if (!$con) {
    die('Could not connect to database..');
  }

  //now run queries

function db_query($query){
  global $con;
$stmt = $con->query($query);
$result = $stmt->fetchAll();
return $result;
}//end of db query

$result = db_query('SHOW TABLES');

$table_names = array();
$i = 0;
while ($i < sizeof($result)) {
  $table_names[$i] = $result[$i][0];
  $table_names[$i];
  $i++;
}

if (empty($table_names)) {
  echo "No tables found..";
}

//now we can generate all sql statements
$stmt_list = array();
$i = 0;
while ($i < sizeof($table_names)) {
  $result = db_query("SHOW CREATE TABLE $table_names[$i]");
  $stmt_list[$i] = $result[0][1];
  $i++;
}

$i = 0;
while($i < sizeof($stmt_list)){
  echo "<br>";
  echo $stmt_list[$i];
  $i++;
}




 ?>
