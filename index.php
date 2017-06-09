<?php
/**
 * Created by PhpStorm.
 * User: mwurp
 * Date: 6/8/2017
 * Time: 12:38 PM
 */
echo "Hello World<br>";
//phpinfo();


$mysqli = new mysqli("localhost", "mobindex", "lQu8H6ijPNYxCqL", "mobindex");

//show tables
$result = $mysqli->query("SHOW TABLES");
print_r($result);
while($tableName = mysqli_fetch_row($result))
{
  $table = $tableName[0];
  echo '<h3>' ,$table, '</h3>';
  $result2 = $mysqli->query("SHOW COLUMNS from ".$table.""); //$result2 = mysqli_query($table, 'SHOW COLUMNS FROM') or die("cannot show columns");
  if(mysqli_num_rows($result2))
  {
    echo '<table cellpadding = "0" cellspacing = "0" class "db-table">';
    echo '<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>';
    while($row2 = mysqli_fetch_row($result2))
    {
      echo '<tr>';
      foreach ($row2 as $key=>$value)
      {
        echo '<td>',$value, '</td>';
      }
      echo '</tr>';
    }
    echo '</table><br />';
  }
}


?>