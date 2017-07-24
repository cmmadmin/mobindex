<html>
<meta charset="UTF-8" />
 <head>
  <title>Compare to UPG</title>

<script type="text/javascript">	document.documentElement.className = 'js';</script>
<link rel="stylesheet" type="text/css" href="scripts/datatables.min.css"/>
<script type="text/javascript" src="scripts/datatables.min.js"></script>
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
<!--
    DEV NOTES:
    Required for DataTables to work:
    datatables.min.css			provides base functionality for appearance
    datatables.min.js			provides base functionality
    jquery 1.12.4 or higher		provides base functionality
    dh_svr_process.php			provides server interactivity (customized, includes SQL connection/ table id/ primary key/ columns)
    ssp.class.php				provides server interactivity (baseline)

		Additional Functionalities used:
		math.min.js					provides math.median(a, b, c, ...) and math.distance([x1, y1], [x2, y2])

    -->

<script type="text/javascript" class="init">

    var averageUPGmedian = 48.62068966; // This value needs a live calculation!!

    var dataSub = <?php
        $Country = array_column($_POST,null);
        echo "[", json_encode(explode(",",$Country[0])),"]";  // Opens posted data into js array
        ?>;


    // offline test data :[["Albania","75","20","80","70","61","15","no","no","","","74","","","","","",""]];
            /* offline test data :var dataSet = [
        ["Albania","88","20","80","70","61","15","yse","no",null,null,"74",null,null,null,null,null,null],
        ["Angola","83","18","20","60","15","83","yes","yes","0.56","0.29","141","4","70","25","0.48","308000","76200000"],
        ["Argentina","49","46","56","86","20","62","yes","yes","0.2","0.14","49","3500000","120","350","0.25","190000","772000"],
        ["Australia","36","90","61","51","21","71","yes","yes","0.14","0.14","6","3000000","1600","2200","0.19","739000","1026000"],
        ["Austria","81","55","79","70","60","63","yes","no",null,null,"15",null,null,null,null,null,null],
        ["Bangladesh","80","20","55","60","47","20","yes","no",null,null,"114",null,null,null,null,null,null],
        ["Belgium","65","75","54","94","82","57","yes","no",null,null,"16",null,null,null,null,null,null],
        ["Zimbabwe",null,null,null,null,null,null,"yes","no",null,null,null,null,null,null,null,null,null]
    ];      */

    $(document).ready(function() {
        $('#submitted').DataTable({                                     //This first table is just for showing submitted row
            data: dataSub,                                              //Setup needs to be seperate from the other table in order to prevent
            "paging": false,                                            //filtering and other problems from occurring....
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
                        return row[1] != '' || row[2] != '' || row[3] != '' || row[4] != '' || row[5] != '' || row[6] != '' ?
                            (Math.abs(math.median(  [(row[1]),(row[2]),(row[3]),(row[4]),(row[5]),(row[6]) ].filter(function(x){  return (x !== ( null || '')); }) )
                                    - averageUPGmedian )).toPrecision(4) : "No Data";
                    },
                    "targets": 7
                }

            ]

        });
    });
    </script>

    <script type="text/javascript" class="init">

         // var averageUPGmedian = 48.62068966;

    $(document).ready(function() {

        $('#upgcompare').DataTable( {
            "paging": false,
            "info": false,
            "ajax": "scripts/dh_svr_process.php",
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

                if ( dataSub [0][1] == "" || data[1] == null) {}
                else if ( Math.abs(dataSub[0][1] - data[1]) > 19 ) { $('td', row).eq(1).addClass('high');}
                else if ( Math.abs(dataSub[0][1] - data[1]) < 11 ) { $('td', row).eq(1).addClass('low'); }

                if ( dataSub [0][2] == "" || data[2] == null) {}
                else if ( Math.abs(dataSub[0][2] - data[2]) > 19 ) { $('td', row).eq(2).addClass('high');}
                else if ( Math.abs(dataSub[0][2] - data[2]) < 11 ) { $('td', row).eq(2).addClass('low'); }

                if ( dataSub [0][3] == "" || data[3] == null) {}
                else if ( Math.abs(dataSub[0][3] - data[3]) > 19 ) { $('td', row).eq(3).addClass('high');}
                else if ( Math.abs(dataSub[0][3] - data[3]) < 11 ) { $('td', row).eq(3).addClass('low'); }

                if ( dataSub [0][4] == "" || data[4] == null) {}
                else if ( Math.abs(dataSub[0][4] - data[4]) > 19 ) { $('td', row).eq(4).addClass('high');}
                else if ( Math.abs(dataSub[0][4] - data[4]) < 11 ) { $('td', row).eq(4).addClass('low'); }

                if ( dataSub [0][5] == "" || data[5] == null) {}
                else if ( Math.abs(dataSub[0][5] - data[5]) > 19 ) { $('td', row).eq(5).addClass('high');}
                else if ( Math.abs(dataSub[0][5] - data[5]) < 11 ) { $('td', row).eq(5).addClass('low'); }

                if ( dataSub [0][6] == "" || data[6] == null) {}
                else if ( Math.abs(dataSub[0][6] - data[6]) > 19 ) { $('td', row).eq(6).addClass('high');}
                else if ( Math.abs(dataSub[0][6] - data[6]) < 11 ) { $('td', row).eq(6).addClass('low'); }

                if ( dataSub [0][7] == "" || data[7] == null) {}
                else if ( Math.abs(dataSub[0][7] - data[7]) > 19 ) { $('td', row).eq(7).addClass('high');}
                else if ( Math.abs(dataSub[0][7] - data[7]) < 11 ) { $('td', row).eq(7).addClass('low'); }

                if ( row[1] == null || row[2] || null || row[3] == null || row[4] == null || row[5] == null || row[6] == null) {
                    $('td', row).eq(8).addClass('high');
                }

            },

            "columnDefs": [
                {
                    // Assuming Power Distance is the 1st column, (Name is 0th column)
                    // result is (row) - (dataSub [0][1])
                    // if data or dataSub[0][1] are not blank, return value- else return null  must use empty string for dataSub
                    // test version to show values used for col 1 is
                    // return dataSub[0][1] != "" && row[1] != null ? Math.abs((dataSub[0][1])-(row[1])) + '(' + dataSub[0][1] + ' & ' + row[1] + ')' : "No Data";
                    "render": function ( data, type, row, meta ) {
                        return dataSub[0][1] != '' && row[1] != null ? Math.abs((dataSub[0][1])-(row[1])) : "No Data";
                    },
                    "targets": 1
                },
                {
                    // Assuming Individualism is the 2nd column, result is (row) - (dataSub [0][2])must use empty string for dataSub
                    "render": function ( data, type, row ) {
                        return dataSub[0][2] != '' && row[2] != null ? Math.abs((dataSub[0][2])-(row[2])) : "No Data";
                    },
                    "targets": 2
                },
                {
                    // Assuming Masculinity is the 3rd column, result is (row) - (dataSub [0][3])must use empty string for dataSub
                    "render": function ( data, type, row ) {
                        return dataSub[0][3] != '' && row[3] != null ? Math.abs((dataSub[0][3])-(row[3])) : "No Data";
                    },
                    "targets": 3
                },
                {
                    // Assuming Uncertainty Avoidance is the 4th column, result is (row) - (dataSub [0][4])must use empty string for dataSub
                    "render": function ( data, type, row ) {
                        return dataSub[0][4] != '' && row[4] != null ? Math.abs((dataSub[0][4])-(row[4])) : "No Data";
                    },
                    "targets": 4
                },
                {
                    // Assuming Long Term Orientation is the 5th column, result is (row) - (dataSub [0][5])must use empty string for dataSub
                    "render": function ( data, type, row ) {
                        return dataSub[0][5] != '' && row[5] != null ? Math.abs((dataSub[0][5])-(row[5])) : "No Data";
                    },
                    "targets": 5
                },
                {
                    // Assuming Indulgence is the 6th column, result is (row) - (dataSub [0][6]) must use empty string for dataSub
                    "render": function ( data, type, row ) {
                        return dataSub[0][6] != '' && row[6] != null ? Math.abs((dataSub[0][6])-(row[6]))  : "No Data";
                    },
                    "targets": 6
                },
                {
                    // Assuming Median is the 7th column, result is (countrymedian) - (dataSub [0][7])
                    "render": function ( data, type, row ) {
                        return row[1] != null || row[2] != null || row[3] != null || row[4] != null || row[5] != null ||row[6] != null ?
                            math.median ( Array.from([
                                dataSub[0][1] != '' && row[1] != null ? Math.abs(  dataSub[0][1]- row[1]  ): '',
                                dataSub[0][2] != '' && row[2] != null ? Math.abs(  dataSub[0][2]- row[2]  ): '',
                                dataSub[0][3] != '' && row[3] != null ? Math.abs(  dataSub[0][3]- row[3]  ): '',
                                dataSub[0][4] != '' && row[4] != null ? Math.abs(  dataSub[0][4]- row[4]  ): '',
                                dataSub[0][5] != '' && row[5] != null ? Math.abs(  dataSub[0][5]- row[5]  ): '',
                                dataSub[0][6] != '' && row[6] != null ? Math.abs(  dataSub[0][6]- row[6]  ): ''
                            ]  ).filter(function(x){  return (x !== ( null || '')); })   ).toPrecision(4): "No Data";

                    },
                    "targets": 7
                },
                {
                    // Assuming Partial Data indicator is the 8th column, result is "Partial Data" if any column is null
                    "render": function ( data, type, row ) {
                        return row[1] != null && row[2] != null && row[3] != null && row[4] != null && row[5] != null && row[6] ? "" : "Partial Data";
                    },
                    "targets": 8
                },

                {
                    // Space for geodata
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