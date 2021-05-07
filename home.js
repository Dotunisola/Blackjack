
var cool = "The Best";
        console.log('hello');
       // alert(cool);
function Dummy() {
    var my_array = [];
    var answer =  prompt("what is your age?");
    var resultN = "Your Name is " + answer;
    let x = 0;

    for (x; x.length < 10; x++) {
        my_array.push(x.resultN);
    }

    var doc = document.getElementById("one");
    doc.innerHTML = my_array;

}

 
//Dummy();

//While
/* var num = 20;

function click(num) {
  while (num < 100) {
      num++;
      console.log(num);   
    //alert(num);
    }
}

click(num); */

//loop

/* for (var num = 0; num < 10; num++) {
    console.log(num);
} */

var fru = "Apples";
var frui = "Apples\nBanana\nGuava"
console.log(frui);


let fruits = ['Apples', 'Banana', 'Pears', 'Ogede'];

for (let x = 0; x < fruits.length; x++) {
    console.log(fruits[x]);
    console.log(fruits.join('|'));
}

var list = [];

for (let x = 0; x < 10; x++) {
   console.log(list.push(x));

}   