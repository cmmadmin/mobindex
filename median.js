Math.median = function() {
var ary, numA, i;
ary = Array.prototype.slice.call(arguments);
for (i = ary.length-1; i >= 0; i--) {if (ary[i] !== +ary[i]) ary[i] = Number.NEGATIVE_INFINITY;}
numA = function(a, b){return (a-b);};
ary.sort(numA);
while (ary.length > 1 && !isFinite(ary[0])) ary.shift();
return ary[Math.floor(ary.length/2)];
}

/* call examples
median1 = Math.median(5,6,4,' ','wart','',' ',3,7);
median2 = Math.median.apply(Math,myArray);
*/