package main

import (

	"fmt"

	"net"

	"os"
	//"strings"
	//"bitbucket.org/secad-s19/golang/jsondb/users"
	"encoding/json"
	"encoding/hex"
	"crypto/sha256"
	"golang.org/x/crypto/pbkdf2"
	"io/ioutil"
     
)


const BUFFERSIZE int = 1024
var buffer [BUFFERSIZE]byte

var allclient_conns = make(map[net.Conn]string)

var newclient = make(chan net.Conn)

    

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

	fmt.Println("EchoServer in GoLang customized by Sagarika Madhavan, SecAD-S19")

	fmt.Printf("EchoServer is listening on port '%s' ...\n", port)
	go func(){

      for{

        client_conn, _ := server.Accept()
        go loginData(client_conn)
        //go client_goroutine(client_conn, allclient_conns)

        //newclient <- client_conn

	}

    }()

    
        for {

            select {

                case client_conn :=<-newclient:

                     fmt.Printf("A new client '%s' is authenticated.!\n", client_conn.RemoteAddr().String())

                     allclient_conns[client_conn] = client_conn.RemoteAddr().String()

                    go client_goroutine(client_conn, allclient_conns)

            }

        }

}
func loginData(client_conn net.Conn){
	byte_received, read_err := client_conn.Read(buffer[0:])
	if read_err != nil{
		fmt.Printf("Error in reading")
		return
	}
	type User struct{
		Username string
		Password string
	 }
	 var user User
  	data := buffer[0:byte_received]
	fmt.Printf("Data received = %s", string(data))
 
	 err := json.Unmarshal(data,&user)
	 if err!=nil || user.Username == "" || user.Password == "" {
	 	fmt.Printf(" JSON parsing error: %s\n",err)
	 	return
	 }
	  fmt.Printf("username= %s, password=%s",user.Username,user.Password)


	
	if checkloggedin(user.Username,user.Password){
		fmt.Printf("Ok")
		sendTo(client_conn, []byte("Login succesful[LOGGED]"))
	}else{
		fmt.Printf("fail")
		sendTo(client_conn, []byte("Authentication failed. Try again\n"))
		loginData(client_conn)
	}
}
func checkloggedin(username string,password string) bool{
		  return MycheckAccount(username,password)
	/*	
	if strings.Contains(data,"password="){
	password := data[9:len(data)]
	fmt.Printf("password = %s", password)
	return true//checkAccount("username", password)
	
	}else{
		return false
	}*/
}

func MycheckAccount(username string, password string) bool {

type Userlogin struct {
	Username string `json:"username"`
	Password string `json:"password"`
}
	type jsonuserlist struct{
		Users []Userlogin
	}
	jsonFilepoint, err := os.Open("users-database.json")												//json file open
	if err !=nil {
		fmt.Println(err)
	}
	fmt.Println("Successfully opened users-database.json file")
	defer jsonFilepoint.Close()
	byteValue, _ := ioutil.ReadAll(jsonFilepoint)
	var userdb jsonuserlist
	json.Unmarshal([]byte(byteValue), &userdb)

	//fmt.Println(jsonUsers ["users-database.json"])

	for i := 0; i < len(userdb.Users); i++ {
		hashed := getHash(username, password)
		if username == userdb.Users[i].Username && hashed == userdb.Users[i].Password {
			return true
		}
	}
	return false
}
func getHash(salt string,valstring string)string { 
	hashed_data := hex.EncodeToString(pbkdf2.Key([]byte(valstring),[]byte(salt),4096,32,sha256.New))
	return hashed_data
}


func client_goroutine(client_conn net.Conn, allClient_conns map[net.Conn]string) {


  //fmt.Printf("A new client '%s' connected!\n", client_conn.RemoteAddr().String())

   //allClient_conns[client_conn]=client_conn.RemoteAddr().String()

   fmt.Printf("# of connected clients: %d\n",len(allClient_conns))

    //todo

    //go sendtoAll(, data)

	

	for {

		byte_received, read_err := client_conn.Read(buffer[0:])

		if read_err != nil {

			fmt.Println("Error in receiving...")
			fmt.Println("Disconnected Client")
			return

		}

                _, write_err := client_conn.Write(buffer[0:byte_received])

		if write_err != nil {

			fmt.Println("Error in receiving...")

			return

		}

		

		data := buffer[0:byte_received]

        go sendtoAll(allClient_conns, data)

		fmt.Printf("Received data: %sEchoed back!\n", buffer)

	   }

}
//func getHash(var salt,var valstring)string{
	//hashed_data := hex.EncodeToString(pbkdf2.Key([]byte(data),[]byte(salt),4096,32,sha256.New)


func sendtoAll(allClient_conns map[net.Conn]string, data []byte){

    for client_conn, _ := range allClient_conns{

        _, write_err := client_conn.Write(data)

		if write_err != nil {

			fmt.Println("Error in receiving...")

			return

                }

    }
}

    func sendTo(client_conn net.Conn, data []byte){

        _, write_err := client_conn.Write(data)

		if write_err != nil {

			fmt.Println("Error in receiving...")

			return

                }

    }



