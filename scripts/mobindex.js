var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        jsonobj = xhttp.responseText;
    }
};
xhttp.open("GET", "scripts/convertcsv.json", false);
xhttp.send();

var dataSet= JSON.parse(jsonobj);
dataSet.forEach(dumpNA);

function post(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.

    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
        }
    }

    document.body.appendChild(form);
    form.submit();
}


$(document).ready(function() {
    $('#example').DataTable( {
        data:dataSet,
        "scrollX": true,
        "paging": false,

        fixedHeader: {
            header: true,
            headerOffset: $('#main-header').height()
        },

        dom: 'Bfrtip',
        select: {style: 'single'},
        columns: [
            { "data": 0, title: "&#127760", className:"country" },					/* table col 0, data source = 0 "Country"  */
            { "data": 1, title: "&#128200", className:"power" },					/* table col 1, data source = 1 "Power Distance" */
            { "data": 2, title: "&#9432", className:"individualism" },				/* table col 2, data source = 2 "Individualism"  */
            { "data": 3, title: "&#128170", className:"masculinity" },				/* table col 3, data source = 3 "Masculinity" */
            { "data": 4, title: "&#x1f4d6", className:"uncertainty" },				/* table col 4, data source = 4 "Uncertainty Avoidance" */
            { "data": 5, title: "&#128198", className:"orientation" },				/* table col 5, data source = 5 "Long Term Orientation"  */
            { "data": 6, title: "&#128526", className:"indulgence" },				/* table col 6, data source = 6 "Indulgence" */
            { "data": 7, title: "UPG Nation" },					                    /* hidden table col 7, data source = 7 */
            { "data": 8, title: "Mob Index Nation" },				                /* hidden table col 8, data source = 8 */
            { "data": null, title: "&#37", className:"median" },		    /* table col 9, data source = calculated TBE, "data" column is placeholder "Average Median Cultural Distance to UPG's" */
            { "data": null, title: "&#128591", className:"freedom" },		/* table col 10, data source = calc from 9&10, "data" column is placeholder Religious Freedoms  */
            { "data": 9, title: "Government Restrictions Index (GRI)" },		    /* hidden table col 11, data source = 9 */
            { "data": 10, title: "Social Hostilities Index (SHI)" },				/* hidden table col 12, data source = 10 */
            { "data": 11, title: "&#128176", className:"prosperity" },				/* table col 13, data source = 11 "Prosperity Rank"   */
            { "data": 12,
                "render": $.fn.dataTable.render.number( ',', '.', 0),					/* render data formatting */
                title: "&#10014", className:"evangelical" },							/* table col 14, data source = 12  "Evangelical #s" */
            { "data": 13,
                "render": $.fn.dataTable.render.number( ',', '.', 0),					/* render data formatting */
                title: "&#9737", className:"incountry" },						        /* table col 15, data source = 13  "Current Sending In Country" */
            { "data": 14,
                "render": $.fn.dataTable.render.number( ',', '.', 0),					/* render data formatting */
                title: "&#9992", className:"abroad" },							        /* table col 16, data source = 14 "Current Sending Abroad"  */
            { "data": 15, title: "&#60 15 ", className:"lessfifteen" },					/* table col 17, data source = 15 "% less than 15 years"   */
            { "data": 16,
                "render": $.fn.dataTable.render.number( ',', '.', 0),					/* render data formatting */
                title: "&#9919", className:"incountryupg" },							/* table col 18, data source = 16 "In Country UPG Access" */
            { "data": 17,
                "render": $.fn.dataTable.render.number( ',', '.', 0),					/* render data formatting */
                title: "&#174 &#9919", className:"regionalupg" }						/* table col 19, data source = 17 "Regional UPG Access" */
        ],

        "columnDefs": [
            {
                "targets": [ 7, 8, 11, 12 ],							// selects table col 7,8,11,12
                "visible": false													// hide selected columns
            },
            {

                "render": function ( data, type, row ) {
                    return notEmpty(row[1]) || notEmpty(row[2]) || notEmpty(row[3]) || notEmpty(row[4]) || notEmpty(row[5]) || notEmpty(row[6]) ?
                        upgAvgMedianDiff(
                            [   notEmpty(data[1]) ? parseFloat(data[1]) : "-" ,
                                notEmpty(data[2]) ? parseFloat(data[2]) : "-" ,
                                notEmpty(data[3]) ? parseFloat(data[3]) : "-" ,
                                notEmpty(data[4]) ? parseFloat(data[4]) : "-" ,
                                notEmpty(data[5]) ? parseFloat(data[5]) : "-" ,
                                notEmpty(data[6]) ? parseFloat(data[6]) : "-" ],
                            upgYes(dataSet)
                        ) : "-";

                    //if all 6 columns are null display "No Data"

                },
                "targets": 9
            },
            {
                // Assuming Rel Freedoms is the 10th column,
                // result is (GRI*.66667) + (SHI*.33333)
                // if data9 or data10 are not blank, return value- else return No Data
                "render": function ( data, type, row ) {
                    return notEmpty(row[9]) && notEmpty(row[10]) ? ((row[9]*.6667)+(row[10]*.33333)).toPrecision(3) : "-";
                },
                "targets": 10
            },
            {
                // Change display to %
                "render": function ( data, type, row ) {
                    return notEmpty(row[15])?toPct(row[15]): "-";
                },
                "targets": 17
            }

        ],

        buttons: [
            {
                extend: 'selected',
                action: function ( e, dt, node, config ) {
                    var rows = dt.rows({selected: true}).data();
                    if (dt.rows( { selected: true } ).count() !== 1) {
                        alert ('Only 1 country may be selected for this function');
                    }
                    else {
                        post('upg.php', rows );
                    }
                },

                text: 'Compare to UPG Nations'
            },
            {
                extend: 'selected',
                action: function ( e, dt, node, config ) {
                    var rows = dt.rows( { selected: true } ).data();
                    if (dt.rows( { selected: true } ).count() !== 1) {
                        alert ('Only 1 country may be selected for this function');
                    }
                    else {
                        post("cultures.php", rows);}
                },
                text: 'Compare Cultures'
            }
        ]

    } );

    $('#example tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );

    $(document).on('mouseover', '.country', function (event) { showTooltip( this, event, 'Country' ); });
    $(document).on('mouseover', '.power', function (event) { showTooltip( this, event, 'Power Distance' ); });
    $(document).on('mouseover', '.individualism', function (event) { showTooltip( this, event, 'Individualism' ); });
    $(document).on('mouseover', '.masculinity', function (event) { showTooltip( this, event, 'Masculinity' ); });
    $(document).on('mouseover', '.uncertainty', function (event) { showTooltip( this, event, 'Uncertainty Avoidance' ); });
    $(document).on('mouseover', '.orientation', function (event) { showTooltip( this, event, 'Long Term Orientation' ); });
    $(document).on('mouseover', '.indulgence', function (event) { showTooltip( this, event, 'Indulgence' ); });
    $(document).on('mouseover', '.median', function (event) { showTooltip( this, event, 'Average Median Cultural Distance to UPGs' ); });
    $(document).on('mouseover', '.freedom', function (event) { showTooltip( this, event, 'Religious Freedoms' ); });
    $(document).on('mouseover', '.prosperity', function (event) { showTooltip( this, event, 'Prosperity Rank' ); });
    $(document).on('mouseover', '.evangelical', function (event) { showTooltip( this, event, 'Number of Evangelicals' ); });
    $(document).on('mouseover', '.incountry', function (event) { showTooltip( this, event, 'Current Sending In Country' ); });
    $(document).on('mouseover', '.abroad', function (event) { showTooltip( this, event, 'Current Sending Abroad' ); });
    $(document).on('mouseover', '.lessfifteen', function (event) { showTooltip( this, event, '% less than 15 years' ); });
    $(document).on('mouseover', '.incountryupg', function (event) { showTooltip( this, event, 'In Country UPG Access' ); });
    $(document).on('mouseover', '.regionalupg', function (event) { showTooltip( this, event, 'Regional UPG Access' ); });

} );