/*
 Assumptions:

 dataSet is the full country list with all data
 upgYes function creates subset of dataSet, only contains datapoints structured as below:
 [
 ["Individualism", "Masculinity", "Uncertainty Avoidance", "Long Term Orientation", "Indulgence" ], //First UPG
 ["Individualism", "Masculinity", "Uncertainty Avoidance", "Long Term Orientation", "Indulgence" ], //Next UPG
 .....
 ["Individualism", "Masculinity", "Uncertainty Avoidance", "Long Term Orientation", "Indulgence" ]  //Last UPG
 ]

 upg.php uses data as such:-----------------------------------------------------------------------------------------
 // dataSub is assigned via json_encode of $_POST data
 // typical format is as below
 var dataSub = [["Albania","88","20","80","70","61","15","no","no","","","74","","","","","",""]];
 //This will be revised methodology, was a hard coded var of minimal upg values
 upgYes(dataSet) will produce a minimized array of upg data

 <single data row>
 return row[1] != null || row[2] != null || row[3] != null || row[4] != null || row[5] != null || row[6] != null ?
 upgAvgMedianDiff( [dataSub[0][1],dataSub[0][2],dataSub[0][3],dataSub[0][4],dataSub[0][5],dataSub[0][6]], upgYes(dataSet) )
 : null;            // This will populate the render data with the upgAvgMedianDiff of the row and upg of the dataSet

 comparisons.htm uses data as such:---------------------------------------------------------------------------------
 <single data row>
 return row[1] != null || row[2] != null || row[3] != null || row[4] != null || row[5] != null || row[6] != null ?
 upgAvgMedianDiff( [row[1],row[2],row[3],row[4],row[5],row[6]], upgYes(dataSet) )
 : null;            // This will populate the render data with the upgAvgMedianDiff of the row and upg of the dataSet

 culture.php uses data as such:-----------------------------------------------------------------------------------------
TBD.
upgAvgMedianDiff ( [array of sending country data], [array of selected country data]) will compute the median difference


 */

function isEmpty(val) {
    return (val == "na" || val == "-" || val === undefined || val == null || val.length <= 0) ? true : false;
}

function notEmpty(val) {
    return (val == "na" || val == "-" || val === undefined || val == null || val.length <= 0) ? false : true;
}

function toPct(item){
    return isNaN(item)? item  : (item*100).toPrecision(2)+"%"
}

function upgLineMedian (r1,r2,r3,r4,r5,r6,d1,d2,d3,d4,d5,d6){
    var rd1= (notEmpty(r1)  &&  notEmpty(d1)) ? Math.abs(r1-d1): "-";
    var rd2= (notEmpty(r2)  &&  notEmpty(d2)) ? Math.abs(r2-d2): "-";
    var rd3= (notEmpty(r3)  &&  notEmpty(d3)) ? Math.abs(r3-d3): "-";
    var rd4= (notEmpty(r4)  &&  notEmpty(d4)) ? Math.abs(r4-d4): "-";
    var rd5= (notEmpty(r5)  &&  notEmpty(d5)) ? Math.abs(r5-d5): "-";
    var rd6= (notEmpty(r6)  &&  notEmpty(d6)) ? Math.abs(r6-d6): "-";
    var tempArr = [];
    if (notEmpty(rd1) ) { tempArr.push(rd1); }
    if (notEmpty(rd2) ) { tempArr.push(rd2); }
    if (notEmpty(rd3) ) { tempArr.push(rd3); }
    if (notEmpty(rd4) ) { tempArr.push(rd4); }
    if (notEmpty(rd5) ) { tempArr.push(rd5); }
    if (notEmpty(rd6) ) { tempArr.push(rd6); }
    return (typeof tempArr !== 'undefined' && tempArr.length > 0)?math.median(tempArr):"-";
}

function dumpNA(item){
    if (isEmpty(item[1])) {item[1]="-"}
    if (isEmpty(item[2])) {item[2]="-"}
    if (isEmpty(item[3])) {item[3]="-"}
    if (isEmpty(item[4])) {item[4]="-"}
    if (isEmpty(item[5])) {item[5]="-"}
    if (isEmpty(item[6])) {item[6]="-"}
    if (isEmpty(item[7])) {item[7]="-"}
    if (isEmpty(item[8])) {item[8]="-"}
    if (isEmpty(item[9])) {item[9]="-"}
    if (isEmpty(item[10])){item[10]="-"}
    if (isEmpty(item[11])){item[11]="-"}
    if (isEmpty(item[12])){item[12]="-"}
    if (isEmpty(item[13])){item[13]="-"}
    if (isEmpty(item[14])){item[14]="-"}
    if (isEmpty(item[15])){item[15]="-"}
    if (isEmpty(item[16])){item[16]="-"}
    if (isEmpty(item[17])){item[17]="-"}
    if (isEmpty(item[18])){item[18]="-"}
}

function upgYes(dataSet) {
    // assumes full dataSet only
    // returns minimal set of upg data used in upgAvgMedian calculation
    arrTemp = [];
    dataSet.forEach(function (item) {
        if (item[7] == "yes") {
            arrTemp.push(item);
        }
    });
    return toMinimal(arrTemp);

}

function toMinimal(arr) {
// accepts array in full data format and returns array in minimal format
// assumes structure such as [["Brazil","69","38","49","76","44","59","no","yes","0.02","0.37","52","50000000","200","2200","0.23","118000","772000"]];

    arrTemp = [];
    arr.forEach(function (item) {
        var subarray = [];				//create blank array for storing subarray values
        //note that only values 0-6 are used
        //assumes structured data is in locations 0-6, other locations ignored
        if (notEmpty(item[1]) ) { subarray.push(item[1]); }	// Assumes item[1] is Power Distance
        if (notEmpty(item[2]) ) { subarray.push(item[2]); }	// Assumes item[2] is Individualism
        if (notEmpty(item[3]) ) { subarray.push(item[3]); }	// Assumes item[3] is Masculinity
        if (notEmpty(item[4]) ) { subarray.push(item[4]); }	// Assumes item[4] is Uncertainty Avoidance
        if (notEmpty(item[5]) ) { subarray.push(item[5]); }	// Assumes item[5] is Long Term Orientation
        if (notEmpty(item[6]) ) { subarray.push(item[6]); }	// Assumes item[6] is Indulgence
        arrTemp.push(subarray);				//push subarray values or empty array to the difference array
    });
    return arrTemp;
}


function upgAvgMedianDiff(mod, arr) {
    /*
     This function accepts 2 arrays
     arr is the array to be modified, mod is the modifier
     assumes arr is an array of arrays
     assumer mod is an array

     requires the functionality of math.min.js
     */

    var arrDiff = [];					//create blank array for storing difference of arr - mod
    arr.forEach(function (item) {
        var subarray = [];				//create blank array for storing subarray values
        //note that only values 0-5 are used
        //assumes structured data is in locations 0-5 (equivalent toMinimal)
        if (    notEmpty(item[0])  &&  notEmpty(mod[0])    ) { subarray.push(Math.abs(item[0] - mod[0]));  }
        if (    notEmpty(item[1])  &&  notEmpty(mod[1])    ) { subarray.push(Math.abs(item[1] - mod[1]));  }
        if (    notEmpty(item[2])  &&  notEmpty(mod[2])    ) { subarray.push(Math.abs(item[2] - mod[2]));  }
        if (    notEmpty(item[3])  &&  notEmpty(mod[3])    ) { subarray.push(Math.abs(item[3] - mod[3]));  }
        if (    notEmpty(item[4])  &&  notEmpty(mod[4])    ) { subarray.push(Math.abs(item[4] - mod[4]));  }
        if (    notEmpty(item[5])  &&  notEmpty(mod[5])    ) { subarray.push(Math.abs(item[5] - mod[5]));  }
        arrDiff.push(subarray);				//push subarray values or empty array to the difference array
    });
    if (typeof arrDiff !== 'undefined' && arrDiff.length > 0) {
        // the array is defined and has at least one element

        var arrMedian = [];					//create blank array for storing median of each subarray
        arrDiff.forEach(function (item) {
            if (typeof item !== 'undefined' && item.length > 0) {				//ignore null values
                var m = math.median(item);

                arrMedian.push(m);				//push subarray median value
            }
        });

        //get average of all median values
            var average = (arrMedian.reduce(( p,c ) => p+c, 0) / arrMedian.length);
            return isNaN(average)? "-"  : average.toPrecision(4)

    }

    // arrDiff was undefined
    return "-";

}