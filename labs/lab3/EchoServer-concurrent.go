/* Simple EchoServer in GoLang by Phu Phung, customized by <Sagarika Madhavan> for SecAD-S19*/
package main

import (
	"fmt"
	"net"
	"os"
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
	fmt.Println("EchoServer in GoLang developed by Sagarika Madhavan, SecAD-S19")
	fmt.Printf("EchoServer is listening on port '%s' ...\n", port)
	allClient_conns := make(map[net.Conn]string) //mapping with connection and string

	newclient := make(chan net.Conn)
	go func() {

	for {
		client_conn, _ := server.Accept()
		//go client_goroutine(client_conn,allClient_conns)
		newclient <- client_conn
		}
	}()
	for{
		select{
		case client_conn := <-newclient:
			fmt.Printf("A new client '%s' connected!\n", client_conn.RemoteAddr().String())
			allClient_conns[client_conn]= client_conn.RemoteAddr().String()
			go client_goroutine(client_conn,allClient_conns)

		}
	}

}
func client_goroutine(client_conn net.Conn, allClient_conns map[net.Conn]string ) {

	//fmt.Printf("A new client '%s' connected!\n", client_conn.RemoteAddr().String())
	//allClient_conns[client_conn]= client_conn.RemoteAddr().String()

	
	fmt.Printf("# of connected clients: %d\n", len(allClient_conns))

	var buffer [BUFFERSIZE]byte
	for {
		byte_received, read_err := client_conn.Read(buffer[0:])
		if read_err != nil {
			fmt.Println("Error in receiving...")
			return
		}
		_, write_err := client_conn.Write(buffer[0:byte_received])
		if write_err != nil {
			fmt.Println("Error in receiving...")
			return
		}
		fmt.Printf("Received data: %sEchoed back!\n", buffer)
	}

}
