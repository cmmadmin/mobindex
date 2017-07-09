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

<p>Compare UPG</p>

            <?php
		$Country = array_column($_POST,null);
		echo "<p>Sending country is ", $Country[0], "</p>";
            ?>

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

    $(document).ready(function() {
        $('#upgcompare').DataTable( {
            "paging": false,
            "info": false,
            "ajax": "scripts/dh_svr_process.php",
            "createdRow": function ( row, data, index ) {
                if ( data[7] == "no" ) {
                    $('td', row).remove();
                }
            },

            "scrollX": true,

            columns: [
                { title: "Country" },
                { title: "Power Distance" },
                { title: "Individualism" },
                { title: "Masculinity" },
                { title: "Uncertainty Avoidance" },
                { title: "Long Term Orientation" },
                { title: "Indulgence" },
                { title: "UPG Nation" },
                { title: "Mob Index Nation" }
                //columns removed for test...
                /*   ,
                 { title: "Government Restrictions Index (GRI)" },
                 { title: "Social Hostilities Index (SHI)" },
                 { title: "Prosperity Rank" },
                 { title: "Evangelical #s" },
                 { title: "Current Sending In Country" },
                 { title: "Current Sending Abroad" },
                 { title: "% less than 15 years" },
                 { title: "In Country UPG Access" },
                 { title: "Regional UPG Access" },
                 { title: "Median" },
                 { title: "Geographic Distance" } */
            ]

        } );

        $('#upgcompare tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('selected');
        } );

    } );

</script>

<div class="et_pb_row">
    <h1>UPG Comparisons</h1>

    <table id="upgcompare" class="display dataTable no-footer" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
    </table>

</div>


 </body>

<button onclick="goBack()">Return</button>

<script>
function goBack() {
    window.history.back();
}
</script>

</html>