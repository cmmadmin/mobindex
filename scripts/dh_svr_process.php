<?php
 
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
 
// DB table to use
$table = 'test';
 
// Table's primary key
$primaryKey = 'Country';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'Country', 'dt' => 0 ),
    array( 'db' => 'Power Distance', 'dt' => 1 ),
    array( 'db' => 'Individualism', 'dt' => 2 ),
    array( 'db' => 'Masculinity', 'dt' => 3 ),
    array( 'db' => 'Uncertainty Avoidance', 'dt' => 4 ),
    array( 'db' => 'Long Term Orientation', 'dt' => 5 ),
    array( 'db' => 'Indulgence', 'dt' => 6 ),
    array( 'db' => 'UPG Nation', 'dt' => 7 ),
    array( 'db' => 'Mob Index Nation', 'dt' => 8 ),
    array( 'db' => 'Government Restrictions Index (GRI)', 'dt' => 9 ),
    array( 'db' => 'Social Hostilities Index (SHI)', 'dt' => 10 ),
    array( 'db' => 'Prosperity Rank', 'dt' => 11 ),
    array( 'db' => 'Evangelical #s', 'dt' => 12 ),
    array( 'db' => 'Current Sending In Country', 'dt' => 13 ),
    array( 'db' => 'Current Sending Abroad', 'dt' => 14 ),
    array( 'db' => '% less than 15 years', 'dt' => 15 ),
    array( 'db' => 'In Country UPG Access', 'dt' => 16 ),
    array( 'db' => 'Regional UPG Access', 'dt' => 17 )
);
 
// SQL server connection information
$sql_details = array(
    'user' => 'id1991384_test',
    'pass' => 'test777',
    'db'   => 'id1991384_test',
    'host' => 'localhost'
);
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( 'ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);