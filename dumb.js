const fs = require("fs");


fs.exists("./dumb3.js", (vaue) => { 
    console.log(vaue)
})
function myDumb(x){
    if(x == 1) {
        console.log("where are you at the moment?");
    }
}

myDumb(1);
