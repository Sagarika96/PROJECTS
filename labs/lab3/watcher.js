const fs = require('fs'); //file system module in node
fs.watch('target.txt',function() { console.log("File target.txt just changed!");//callback
});
console.log("Now watching target.txt for changes...");
