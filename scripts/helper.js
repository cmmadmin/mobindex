/*
This function accepts 2 arrays
arr is the array to be modified, mod is the modifier

requires the functionality of math.min.js
 */

function upgAvgMedianDiff( mod, arr){

// testing line    document.getElementById("aupg").innerHTML = "arr= " + arr;
// testing line    document.getElementById("aall").innerHTML = "mod = " + mod;

    var upgDiff = [];
    arr.forEach(function(item){
        var subarray = [];
        if (item[0] != null){ subarray.push( Math.abs (item[0]-mod[0] )  );}
        if (item[1] != null){ subarray.push( Math.abs (item[1]-mod[1] )  );}
        if (item[2] != null){ subarray.push( Math.abs (item[2]-mod[2] )  );}
        if (item[3] != null){ subarray.push( Math.abs (item[3]-mod[3] )  );}
        if (item[4] != null){ subarray.push( Math.abs (item[4]-mod[4] )  );}
        if (item[5] != null){ subarray.push( Math.abs (item[5]-mod[5] )  );}
        if (item[6] != null){ subarray.push( Math.abs (item[6]-mod[6] )  );}
        upgDiff.push(subarray);
    });
// testing line    document.getElementById("aupg").innerHTML = "upgDiff: " + upgDiff;

    var upgMedian = [];
    upgDiff.forEach(function(item){
        if (item != null){
            var m= math.median (item);
            upgMedian.push( m);
// testing line            document.getElementById("aall").innerHTML = "upgMedian = " + upgMedian;
        }
        console.log(upgMedian);
    });

    var average =upgMedian.reduce( ( p, c ) => p + c, 0 ) / upgMedian.length;
    return average.toPrecision(4);

}




/*
 // for testing without math.min.js:

 function upgMedian(v, i, arr){
 // change each subarray in upgvals to a median..
 // do filtering here
 arr[i].sort((a, b) => a - b);
 var lowMiddle = Math.floor((arr[i].length - 1) / 2);
 var highMiddle = Math.ceil((arr[i].length - 1) / 2);
 median = (arr[i][lowMiddle] + arr[i][highMiddle]) / 2;
 arr[i] = median;
 }
 */
