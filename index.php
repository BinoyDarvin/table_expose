<?php
$print = false;
if (isset($_POST['submit'])){
  $host = trim($_POST['host']);
  $dbname = trim($_POST['dbname']);
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);



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

$print = true;


}//end of whole if


 ?>



 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
<!--font import-->
      <link href="https://fonts.googleapis.com/css?family=Catamaran|Roboto+Mono" rel="stylesheet">
       <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

     <!--bootstrap import-->
     <!-- Latest compiled and minified CSS -->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <!-- custom css -->
  <link rel="stylesheet" href="style.css">
     <title>SQl EXPOSE</title>
   </head>
   <body>
       <div class="ultra-head">SQL EXPOSED</div>
       <form action="" method="post">
         <input type="text" name="host" placeholder="Host name">
       <input type="text" name="dbname" placeholder="Database name">
       <input type="text" name="username" placeholder="Username">
       <input type="passsword" name="password" placeholder="Password">
        <button type="submit" name="submit" class="btn">Submit</button>



       </form>

<!--ouput parts-->
<!--cards-->

<?php
//generate the cards
if ($print) {

$i = 0;
while($i < sizeof($stmt_list)){
echo <<<HEREDOC
<div class="card">
<div class="card-head">$table_names[$i]</div>

    <div class="query-text">
    $stmt_list[$i];
    </div>
</div>
HEREDOC;

$i++;
}

}


 ?>





   </body>
 </html>
