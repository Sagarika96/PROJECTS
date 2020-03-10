/* include libraries */


#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <errno.h>
#include <string.h>
#include <netdb.h>
#include <sys/types.h>
#include <netinet/in.h>
#include <sys/socket.h>
#include <arpa/inet.h>
#define BUFFERSIZE 1024
int main (int argc, char *argv[])
{
<<<<<<< HEAD
   printf("TCP Client program by Sagarika Madhavan for Lab 2 â€“ SecAD - Spring 2019\n");
=======
   printf("TCP Client program by Sagarika Madhavan for Lab 2 – SecAD - Spring 2019\n");
>>>>>>> 5687f6c296db964379b148d92fbf53a768936687
if(argc!=3)
{
printf("ussage: %s <server> <path>\n",argv[0]);
exit(0);
}
char *servername =argv[1];
char *path=argv[2];  //put path instead of port
if(strlen(servername) > 225||strlen(path) > 500)
{
perror("servername or port is too long\n");
exit(1);
}

printf("servername: %s ,path: %s \n",servername,path);
int sockfd =socket(AF_INET, SOCK_STREAM,0);
if(sockfd < 0)
{
perror("error is opening a socket!\n");
exit(2);
}
printf("A socket is opened");
struct addrinfo hints, *serveraddr;
memset(&hints, 0, sizeof hints);
hints.ai_family= AF_INET;
hints.ai_socktype= SOCK_STREAM;
int addr_lookup= getaddrinfo(servername , "80", &hints, &serveraddr);
if (addr_lookup!= 0) {
fprintf(stderr, "getaddrinfo: %s\n",gai_strerror(addr_lookup));
exit(1);
}
int connected = connect(sockfd, serveraddr->ai_addr,serveraddr->ai_addrlen);
if(connected < 0){
perror("Cannot connect to the server\n");
exit(3);
}
else
printf("Connected to the server %s at path %s\n",servername, path);
freeaddrinfo(serveraddr);
char buffer[BUFFERSIZE]; 
bzero(buffer,BUFFERSIZE);
char request[255];
//sprintf(buffer, "GET / HTTP/1.0\r\nHost: %s\r\n\r\n", servername);  
sprintf(buffer,"GET %s HTTP/1.1\r\nHost: %s\r\n\r\n",path,servername);
//fgets(buffer, BUFFERSIZE, stdin);
int byte_sent = send(sockfd,buffer, strlen(buffer), 0);
bzero(buffer,BUFFERSIZE);
int byte_received =recv(sockfd, buffer, BUFFERSIZE, 0);
if(byte_received <0){
perror("Error in reading");
exit(4);
}
printf("Received from server: %s", buffer);
close(sockfd);
return 0;
}//end main function
