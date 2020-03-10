var net = require('net');

if(process.argv.length != 4){
        console.log("Usage: node %s <host> <port>", process.argv[1]);
        process.exit(0);        
}

var host=process.argv[2];
var port=process.argv[3];
var authenticated = false;

if(host.length >253 || port.length >5 ){
        console.log("Invalid host or port. Try again!\nUsage: node %s <port>", process.argv[1]);
        process.exit(1);        
}

var client = new net.Socket();
console.log("Simple ChatClient.js developed by Sagarika Madhavan, SecAD-S19");
console.log("Connecting to: %s:%s", host, port);

client.connect(port,host, connected);

function connected(){
        console.log("Connected to: %s:%s", client.remoteAddress, client.remotePort);
        console.log("You need login before sending/receiving message.\n");
        loginsync();
}

var readlineSync = require('readline-sync');

var username;
var password;
function loginsync(){
        // Wait for user's response.
        username = readlineSync.question('Username:');

        // Handle the secret text (e.g. password).
        password = readlineSync.question('Password:', {
                hideEchoBack: true // The typed text on screen is hidden by `*` (default).
        });

        var creds = '{"Username": "'+ username +'", "Password": "'+ password +'"}';// Construct the login data according to the protocol with the server.

        client.write(creds);
}

client.on("data", (data)=> {
                console.log("Received data:" +data);
                if (!authenticated){
                        if(data.includes("Login succesful")){
                                var d = data + '';
                                username = d.split(" ")[3];//username from the authenticated message
                                console.log("You have logged in successfully");
                                authenticated = true;
                                chat();
                        } else {
                                console.log("Authentication failed. Please try again");
                                loginsync();            
                        } 
                }
});

client.on("error", function(err){
        console.log("Error");
        process.exit(2);
});

client.on("close", function(data){
        console.log("Connection has been disconnected");
        process.exit(3);
});

function chat() {
        const keyboard =  require('readline').createInterface({

        input: process.stdin,
        output: process.stdout
        });

        keyboard.on('line', (input) => {
                console.log(`You typed: ${input}`);
                        if(input === ".exit") {
                                client.destroy();
                                console.log("Connection Closed!");
                                process.exit();
                        }
                client.write(input);
        });
}