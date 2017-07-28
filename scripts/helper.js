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
        if (item[1] != null) { subarray.push(item[1]); }	// Assumes item[1] is Power Distance
        if (item[2] != null) { subarray.push(item[2]); }	// Assumes item[2] is Individualism
        if (item[3] != null) { subarray.push(item[3]); }	// Assumes item[3] is Masculinity
        if (item[4] != null) { subarray.push(item[4]); }	// Assumes item[4] is Uncertainty Avoidance
        if (item[5] != null) { subarray.push(item[5]); }	// Assumes item[5] is Long Term Orientation
        if (item[6] != null) { subarray.push(item[6]); }	// Assumes item[6] is Indulgence
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
        if (item[0] != null) { subarray.push(Math.abs(item[0] - mod[0]));  }
        if (item[1] != null) { subarray.push(Math.abs(item[1] - mod[1]));  }
        if (item[2] != null) { subarray.push(Math.abs(item[2] - mod[2]));  }
        if (item[3] != null) { subarray.push(Math.abs(item[3] - mod[3]));  }
        if (item[4] != null) { subarray.push(Math.abs(item[4] - mod[4]));  }
        if (item[5] != null) { subarray.push(Math.abs(item[5] - mod[5]));  }
        arrDiff.push(subarray);				//push subarray values or empty array to the difference array
    });

    var arrMedian = [];					//create blank array for storing median of each subarray
    arrDiff.forEach(function (item) {
        if (item != null) {				//ignore null values
            var m = math.median(item);

            arrMedian.push(m);				//push subarray median value
        }
    });
    //get average of all median values
    var average = (arrMedian.reduce(( p, c ) => p + c, 0)/arrMedian.length);
    return average.toPrecision(4);

}