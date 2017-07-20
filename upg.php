<html>
<meta charset="UTF-8" />
 <head>
  <title>Compare to UPG</title>

<script type="text/javascript">	document.documentElement.className = 'js';</script>
<link rel="stylesheet" type="text/css" href="scripts/datatables.min.css"/>
<script type="text/javascript" src="scripts/datatables.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-1.12.4.js"></script>
     <style>
         td.highlight {
             font-weight: bold;
             color: blue;
         }
     </style>
 </head>
 <body>

<!--	/* DataTables Stuff */   -->

<link rel="stylesheet" type="text/css" href="scripts/datatables.min.css"/>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/datatables.min.js"></script>
<!--
    DEV NOTES:
    Required for DataTables to work:
    datatables.min.css			provides base functionality for appearance
    datatables.min.js			provides base functionality
    jquery 1.12.4 or higher		provides base functionality
    dh_svr_process.php			provides server interactivity (customized, includes SQL connection/ table id/ primary key/ columns)
    ssp.class.php				provides server interactivity (baseline)

    -->
<script type="text/javascript" class="init">

    var dataSub = <?php
        $Country = array_column($_POST,null);
        echo "[", json_encode(explode(",",$Country[0])),"]";  // Opens posted data into js array
        ?>;

    $(document).ready(function() {
        $('#submitted').DataTable({     //This first table is just for showing submitted row
            data: dataSub,              //Setup needs to be seperate from the other table in order to prevent
            "paging": false,            //filtering and other problems from occurring....
            "scrollX": true,
            "searching": false,

            columns: [
                {title: "Country"},
                {title: "Power Distance"},
                {title: "Individualism"},
                {title: "Masculinity"},
                {title: "Uncertainty Avoidance"},
                {title: "Long Term Orientation"},
                {title: "Indulgence"},
                {title: "Average"}
            ],

            "columnDefs": [
                {
                    // Average UPG Distance
                    "render": function ( data, type, row ) {
                        return "calculate";
                    },
                    "targets": 7
                },

            ],

        });
    });
    </script>

    <script type="text/javascript" class="init">
    $(document).ready(function() {

        $('#upgcompare').DataTable( {
            "paging": false,
            "info": false,
            "ajax": "scripts/dh_svr_process.php",
            "createdRow": function ( row, data, index ) {
                if ( data[7] != "yes" ) {
                    $('td', row).remove();
                }
            },

            "scrollX": true,

            columns: [
                { title: "UPG Country" },
                { title: "Power Distance" },
                { title: "Individualism" },
                { title: "Masculinity" },
                { title: "Uncertainty Avoidance" },
                { title: "Long Term Orientation" },
                { title: "Indulgence" },
                { title: "Median" },
                { title: "Partial Data?" },
                { title: "Geographic Distance" }

            ],

            "columnDefs": [
                {
                    // Assuming Power Distance is the 1st column, (Name is 0th column)
                    // result is (row) - (dataSub [0][1])
                    // if data or dataSub[0][1] are not blank, return value- else return null
                    "render": function ( data, type, row ) {
                        return dataSub[0][1] != null && row[1] != null ? Math.abs((dataSub[0][1])-(row[1])) + '(' + dataSub[0][1] + ' & ' + row[1] + ')' : "null";
                    },
                    "targets": 1
                },
                {
                    // Assuming Individualism is the 2nd column, result is (row) - (dataSub [0][2])
                    "render": function ( data, type, row ) {
                        return dataSub[0][2] != null && row[2] != null ? Math.abs((dataSub[0][2])-(row[2])) + '(' + dataSub[0][2] + ' & ' + row[2] + ')' : "null";
                    },
                    "targets": 2
                },
                {
                    // Assuming Masculinity is the 3rd column, result is (row) - (dataSub [0][3])
                    "render": function ( data, type, row ) {
                        return dataSub[0][3] != null && row[3] != null ? Math.abs((dataSub[0][3])-(row[3])) + '(' + dataSub[0][3] + ' & ' + row[3] + ')' : "null";
                    },
                    "targets": 3
                },
                {
                    // Assuming Uncertainty Avoidance is the 4th column, result is (row) - (dataSub [0][4])
                    "render": function ( data, type, row ) {
                        return dataSub[0][4] != null && row[4] != null ? Math.abs((dataSub[0][4])-(row[4])) + '(' + dataSub[0][4] + ' & ' + row[4] + ')' : "null";
                    },
                    "targets": 4
                },
                {
                    // Assuming Long Term Orientation is the 5th column, result is (row) - (dataSub [0][5])
                    "render": function ( data, type, row ) {
                        return dataSub[0][5] != null && row[5] != null ? Math.abs((dataSub[0][5])-(row[5])) + '(' + dataSub[0][5] + ' & ' + row[5] + ')' : "null";
                    },
                    "targets": 5
                },
                {
                    // Assuming Indulgence is the 6th column, result is (row) - (dataSub [0][6])
                    "render": function ( data, type, row ) {
                        return dataSub[0][6] != null && row[6] != null ? Math.abs((dataSub[0][6])-(row[6])) + '(' + dataSub[0][6] + ' & ' + row[6] + ')' : "null";
                    },
                    "targets": 6
                },
                {
                    // Assuming Median is the 7th column, result is (countrymedian) - (dataSub [0][7])
                    "render": function ( data, type, row ) {
                        return "calculate";
                    },
                    "targets": 7
                },
                {
                    // Assuming Partial Data indicator is the 8th column, result is (countrymedian) - (dataSub [0][7])
                    "render": function ( data, type, row ) {
                        return row[1] != null && row[2] != null && row[3] != null && row[4] != null && row[5] != null && row[6] ? "" : "Partial Data";
                    },
                    "targets": 8
                },

                {
                    // Assuming Partial Data indicator is the 8th column, result is (countrymedian) - (dataSub [0][7])
                    "render": function ( data, type, row ) {
                        return "No Data";
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
    <table id="submitted" class="display dataTable no-footer" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
    </table>

    <table id="upgcompare" class="display dataTable no-footer" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
    </table>

</div>


 </body>



</html>