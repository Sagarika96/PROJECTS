package func main() {
	
}

import (
"fmt"
"net"
"os"
"encoding/json"
)

const BUFFERSIZE int = 1024

func main() {
if len(os.Args) != 2 {
fmt.Printf("Usage: %s <port>\n", os.Args[0])
os.Exit(0)
}
port := os.Args[1]
if len(port) > 5 {
fmt.Println("Invalid port value. Try again!")
os.Exit(1)
}
server, err := net.Listen("tcp", ":"+port)
if err != nil {
fmt.Printf("Cannot listen on port '" + port + "'!\n")
os.Exit(2)
}
fmt.Println("EchoServer in GoLang developed by Sagarika Madhavan,
repo/SecAD-S19/madhavans1")
fmt.Printf("EchoServer is listening on port '%s' ...\n", port)
allClient_conns := make(map[net.Conn]string) //mapping with connection
and string
newclient := make(chan net.Conn)
go func() {
for {
client_conn, _ := server.Accept()
//go client_goroutine(client_conn,allClient_conns)
newclient <- client_conn
}
}()
for {
select {
case client_conn := <-newclient:
fmt.Printf("A new client '%s' connected!\n",
client_conn.RemoteAddr().String())
allClient_conns[client_conn] = client_conn.RemoteAddr().String()
go client_goroutine(client_conn, allClient_conns)
//delete(allClient_conns,client_conn)
//go sendtoAll(allClient_conns,[]byte(welcomemessage))
}
}

}




func client_goroutine(client_conn net.Conn, allClient_conns
map[net.Conn]string) {
fmt.Printf("# clients: %d\n", len(allClient_conns))
lostclient := make(chan net.Conn)
var buffer [BUFFERSIZE]byte
go func() {
for {
byte_received, read_err := client_conn.Read(buffer[0:])
if read_err != nil {
fmt.Println("Error in receiving...,disconnected client,")
lostclient <- client_conn
return
}
data := buffer[0:byte_received]
go sendtoAll(allClient_conns, data)
fmt.Printf("Received data: %sEchoed back!\n", buffer)
}
}()
for {
select {
case client_conn := <-lostclient:
//handling for the event
delete(allClient_conns, client_conn)
}
}
}

func checklogin(data []byte) (bool, string, string){
//expecting format of {"Username":"..","Password":".."}
type Account struct{
Username string
Password string
}
    var account Account
err := json.Unmarshal(data, &account)
if err!=nil || account.Username == "" || account.Password == "" {
fmt.Printf("JSON parsing error: %s\n", err)
return false, "", `[Message to tell the client that the login data is
invalid - follow your design of the protocol]`
}
fmt.Printf("DEBUG>Got: account=%s\n", account)
fmt.Printf("DEBUG>Got: username=%s, password=%s\n",
account.Username,account.Password)
if checkaccount(account.Username,account.Password) {
return true, account.Username, "[Message to tell the client that the
user is authenticated  - follow your design of the protocol]"
}

return false, "" , "[Message to tell the client that the user cannot
login - follow your design of the protocol]"

}

func checkaccount(username string, password string) bool{
//TODO:check the database
if username=="xxx" && password == "yyy"{
return true
}
    //more hard-code username/password here for this version
return false
}


func handleMessages(client_conn net.Conn, data []byte){
   //TODO:
   //handle different types of messages (Not Login)
   //call other functions to handle for each case, do not implement
all within this function
}

func sendtoAll(allClient_conns map[net.Conn]string, data []byte) {
fmt.Printf("# clients: %d\n", len(allClient_conns))
for client_conn, _ := range allClient_conns {
_, write_err := client_conn.Write(data)
if write_err != nil {
fmt.Println("Error in sending...")
return
}
}
}
