<html>
<meta charset="UTF-8" />
 <head>
  <title>Compare to UPG</title>

<script type="text/javascript">	document.documentElement.className = 'js';</script>
<link rel="stylesheet" type="text/css" href="scripts/datatables.min.css"/>
<script type="text/javascript" src="scripts/datatables.min.js"></script>
<script type="text/javascript" src="scripts/geodata.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-1.12.4.js"></script>


     <!--	/* Styling for color choices
                td.low is for good/ close values
                td.high is for bad/ far values
                */   -->

     <style>
         td.highlight {
             font-weight: bold;
             color: blue;
         }
         td.low {
             font-weight: bold;
             color: green;
         }
         td.high {
             font-weight: bold;
             color: red;
         }
     </style>
 </head>
 <body>

<!--	/* DataTables Stuff */   -->

<link rel="stylesheet" type="text/css" href="scripts/datatables.min.css"/>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/datatables.min.js"></script>
<script type="text/javascript" src="scripts/math.min.js"></script>
<script type="text/javascript" src="scripts/helper.js"></script>
<!--
		DEV NOTES:
		Required for DataTables to work:
		datatables.min.css			provides base functionality for appearance
		datatables.min.js			provides base functionality
		jquery 1.12.4 or higher		provides base functionality

		Additional Functionalities used:
		math.min.js					provides math.median(a, b, c, ...) and math.distance([x1, y1], [x2, y2])
		helper.js					custom helper for value conversions
		geodata.js                  provides geodata functions

		-->

<script type="text/javascript" class="init">

    var dataSet= <?php
        $rawdata= file_get_contents('scripts/convertcsv.json');
        echo $rawdata;
        ?>;

    var dataSub = <?php
        $Country = array_column($_POST,null);
        echo "[", json_encode(explode(",",$Country[0])),"]";  // Opens posted data into js array
        ?>;

    $(document).ready(function() {
        $('#submitted').DataTable({                                     //This first table is just for showing submitted row
            data: dataSub,                                              //Setup needs to be seperate from the other table in order to prevent
            "paging": false,                                            //filtering and other problems from occurring....
            "scrollX": true,
            "searching": false,

            columns: [

                { title: "Country" },											/* table col 0, data source = 0 */
                { title: "Power Distance" },									/* table col 1, data source = 1 */
                { title: "Individualism" },										/* table col 2, data source = 2 */
                { title: "Masculinity" },										/* table col 3, data source = 3 */
                { title: "Uncertainty Avoidance" },								/* table col 4, data source = 4 */
                { title: "Long Term Orientation" },								/* table col 5, data source = 5 */
                { title: "Indulgence" },										/* table col 6, data source = 6 */
                { title: "Average Median Cultural Distance to UPG's"}		/* table col 9, data source = calculated, "data" column is placeholder*/

            ],

            "columnDefs": [
{ className: "dt-center", "targets": [ 1,2, 3, 4, 5, 6,7 ] },
               {

                    "render": function ( data, type, row ) {
                        return notEmpty(dataSub[0][1]) || notEmpty(dataSub[0][2]) || notEmpty(dataSub[0][3]) || notEmpty(dataSub[0][4]) || notEmpty(dataSub[0][5]) || notEmpty(dataSub[0][6]) ?
                            upgAvgMedianDiff(
                                [   notEmpty(dataSub[0][1]) ? parseFloat(dataSub[0][1]) : "-" ,
                                    notEmpty(dataSub[0][2]) ? parseFloat(dataSub[0][2]) : "-" ,
                                    notEmpty(dataSub[0][3]) ? parseFloat(dataSub[0][3]) : "-" ,
                                    notEmpty(dataSub[0][4]) ? parseFloat(dataSub[0][4]) : "-" ,
                                    notEmpty(dataSub[0][5]) ? parseFloat(dataSub[0][5]) : "-" ,
                                    notEmpty(dataSub[0][6]) ? parseFloat(dataSub[0][6]) : "-" ],
                                upgYes(dataSet)
                            ) : "-";

                        //if all 6 columns are null display "No Data"

                    },
                    "targets": 7
                }
                ],

            "createdRow": function ( row, data, index ) {
                if (data[7] != null) {
                    $('td', row).eq(7).addClass('highlight');
                }
            }

        });
    });
    </script>

    <script type="text/javascript" class="init">

    $(document).ready(function() {

        $('#upgcompare').DataTable( {
            data: dataSet,
            "paging": false,
            "info": false,
            "scrollX": true,

            columns: [
                { title: "UPG Country"},
                { title: "Power Distance"},
                { title: "Individualism"},
                { title: "Masculinity"},
                { title: "Uncertainty Avoidance" },
                { title: "Long Term Orientation"},
                { title: "Indulgence" },
                { title: "Median" },
                { title: "Partial Data?" },
                { title: "Geographic Distance" }

            ],

            "createdRow": function ( row, data, index ) {
                if ( data[7] != "yes" ) {  $('td', row).remove();  }

                // dataSub [0][x] is the submitted country's column
                // data[x] is the UPG Country column

                if ( isEmpty(dataSub[0][1]) || isEmpty(data[1])) {}
                else if ( Math.abs(dataSub[0][1] - data[1]) > 19 ) { $('td', row).eq(1).addClass('high');}
                else if ( Math.abs(dataSub[0][1] - data[1]) < 11 ) { $('td', row).eq(1).addClass('low'); }

                if ( isEmpty(dataSub[0][2]) || isEmpty(data[2])) {}
                else if ( Math.abs(dataSub[0][2] - data[2]) > 19 ) { $('td', row).eq(2).addClass('high');}
                else if ( Math.abs(dataSub[0][2] - data[2]) < 11 ) { $('td', row).eq(2).addClass('low'); }

                if ( isEmpty(dataSub[0][3]) || isEmpty(data[3])) {}
                else if ( Math.abs(dataSub[0][3] - data[3]) > 19 ) { $('td', row).eq(3).addClass('high');}
                else if ( Math.abs(dataSub[0][3] - data[3]) < 11 ) { $('td', row).eq(3).addClass('low'); }

                if ( isEmpty(dataSub[0][4]) || isEmpty(data[4])) {}
                else if ( Math.abs(dataSub[0][4] - data[4]) > 19 ) { $('td', row).eq(4).addClass('high');}
                else if ( Math.abs(dataSub[0][4] - data[4]) < 11 ) { $('td', row).eq(4).addClass('low'); }

                if ( isEmpty(dataSub[0][5]) || isEmpty(data[5])) {}
                else if ( Math.abs(dataSub[0][5] - data[5]) > 19 ) { $('td', row).eq(5).addClass('high');}
                else if ( Math.abs(dataSub[0][5] - data[5]) < 11 ) { $('td', row).eq(5).addClass('low'); }

                if ( isEmpty(dataSub[0][6]) || isEmpty(data[6])) {}
                else if ( Math.abs(dataSub[0][6] - data[6]) > 19 ) { $('td', row).eq(6).addClass('high');}
                else if ( Math.abs(dataSub[0][6] - data[6]) < 11 ) { $('td', row).eq(6).addClass('low'); }

                if ( isEmpty(dataSub[0][7]) || isEmpty(data[7])) {}
                else if ( row[7] > 19 ) { $('td', row).eq(7).addClass('high');}   // This is not working properly...
                else if ( row[7] < 11 ) { $('td', row).eq(7).addClass('low'); }   // This is not working properly...

                if ( isEmpty(row[1]) || isEmpty(row[2]) || isEmpty(row[3]) || isEmpty(row[4]) || isEmpty(row[5]) || isEmpty(row[6])) {
                    $('td', row).eq(8).addClass('high');
                }

            },

            "columnDefs": [
{ className: "dt-center", "targets": [ 1,2, 3, 4, 5, 6,7 ] },
                {
                    // Assuming Power Distance is the 1st column, (Name is 0th column)
                    // result is (row) - (dataSub [0][1])
                    // if data or dataSub[0][1] are not blank, return value- else return null  must use empty string for dataSub
                    // test version to show values used for col 1 is
                    // return dataSub[0][1] != "" && row[1] != null ? Math.abs((dataSub[0][1])-(row[1])) + '(' + dataSub[0][1] + ' & ' + row[1] + ')' : "No Data";
                    "render": function ( data, type, row, meta ) {
                        return notEmpty(dataSub[0][1]) && notEmpty(row[1]) ? Math.abs((dataSub[0][1])-(row[1])) : "-";
                    },
                    "targets": 1
                },
                {
                    // Assuming Individualism is the 2nd column, result is (row) - (dataSub [0][2])must use empty string for dataSub
                    "render": function ( data, type, row ) {
                        return notEmpty(dataSub[0][2]) && notEmpty(row[2]) ? Math.abs((dataSub[0][2])-(row[2])) : "-";
                    },
                    "targets": 2
                },
                {
                    // Assuming Masculinity is the 3rd column, result is (row) - (dataSub [0][3])must use empty string for dataSub
                    "render": function ( data, type, row ) {
                        return notEmpty(dataSub[0][3]) && notEmpty(row[3]) ? Math.abs((dataSub[0][3])-(row[3])) : "-";
                    },
                    "targets": 3
                },
                {
                    // Assuming Uncertainty Avoidance is the 4th column, result is (row) - (dataSub [0][4])must use empty string for dataSub
                    "render": function ( data, type, row ) {
                        return notEmpty(dataSub[0][4]) && notEmpty(row[4]) ? Math.abs((dataSub[0][4])-(row[4])) : "-";
                    },
                    "targets": 4
                },
                {
                    // Assuming Long Term Orientation is the 5th column, result is (row) - (dataSub [0][5])must use empty string for dataSub
                    "render": function ( data, type, row ) {
                        return notEmpty(dataSub[0][5]) && notEmpty(row[5]) ? Math.abs((dataSub[0][5])-(row[5])) : "-";
                    },
                    "targets": 5
                },
                {
                    // Assuming Indulgence is the 6th column, result is (row) - (dataSub [0][6]) must use empty string for dataSub
                    "render": function ( data, type, row ) {
                        return notEmpty(dataSub[0][6]) && notEmpty(row[6]) ? Math.abs((dataSub[0][6])-(row[6]))  : "-";
                    },
                    "targets": 6
                },
                {
                    // Assuming Median is the 7th column, result is (countrymedian) - (dataSub [0][7])
                    "render": function ( data, type, row ) {
                        return upgLineMedian(row[1], row[2], row[3], row[4], row[5], row[6], dataSub[0][1], dataSub[0][2], dataSub[0][3], dataSub[0][4], dataSub[0][5], dataSub[0][6]);
                    },
                    "targets": 7
                },
                {
                    // Assuming Partial Data indicator is the 8th column, result is "Partial Data" if any column is null
                    "render": function ( data, type, row ) {
                        return isEmpty(row[1]) || isEmpty(row[2]) || isEmpty(row[3]) || isEmpty(row[4]) || isEmpty(row[5]) ||isEmpty(row[6]) ? "Partial Data" : "";
                    },
                    "targets": 8
                },

                {
                    // Space for geodata
                    "render": function ( data, type, row ) {
                        return  notEmpty(row[0]) &&  notEmpty(dataSub[0][0])? GeoRegion(row[0])+ ", " +GeoDiff(dataSub[0][0],row[0]) : "-"; // GeoDiff(dataSub[0][0],row[0])
                    },
                    "targets": 9
                }

            ]

        } );

        $('#upgcompare tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('selected');
        } );

    } );

</script>

<div class="et_pb_row">
    <h1>UPG Comparisons</h1>

<button onclick="goBack()">Return</button>

<script>
function goBack() {
    window.history.back();
}
</script>

    <p>Sending country:</p>
    <table id="submitted" class="display dataTable compact cell-border" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
    </table>

<p>Color Coding key:  <span style="color:green;font-weight:bold">Values <11</span> and <span style="color:red;font-weight:bold">Values >19</span> </p>

    <table id="upgcompare" class="display dataTable compact" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
    </table>

</div>


 </body>



</html>