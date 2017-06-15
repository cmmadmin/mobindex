<?php
/**
 * User: Don H
 * Date: 6/15/2017
 * Time: 10:38 AM
 */

$mysqli = new mysqli("localhost", "mobindex", "lQu8H6ijPNYxCqL", "mobindex");

$q1 = "SHOW TABLES"  			//show tables query setup
$result = $mysqli->query($q1);		//actual show tables query
print_r($result);
while($tableName = mysqli_fetch_row($result))
{
  $table = $tableName[0];		//gets the table name
  $q2 = "SHOW COLUMNS from ".$table	//setup the query for SHOW COLUMNS
  $result2 = $mysqli->query($q2); 	//Object style query


  if(mysqli_num_rows($result2))		//loop to pull the rows to an array
  {
    header('Content-type: application/json');
    while($row = $result->fetch_array(MYSQL_ASSOC)) {	
	$myArray[] = $row;
 	}

	echo json_encode($myArray);	//convert the array to JSON

  }
}


?>