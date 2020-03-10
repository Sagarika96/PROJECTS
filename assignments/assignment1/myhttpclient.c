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
   printf("TCP Client program by Sagarika Madhavan for Lab 2 – SecAD - Spring 2019\n");
if(argc!=2)
{
printf("usage: %s <url> \n",argv[0]);
exit(0);
}
char *url=argv[1];



char servername[100];
char path[3000]; //put path instead of port
if(strlen(url)> 255)
{
perror("servername or path is too long\n");
exit(1);
}


int sockfd =socket(AF_INET, SOCK_STREAM,0);
if(sockfd < 0)
{
perror("error is opening a socket!\n");
exit(2);
}
printf("A socket is opened");
struct addrinfo hints, *serveraddr;
//char *extraction="HTTP/1.%*[01] %d %d"

;


char *urlPattern = "http://%[^/]/%s/%s";
  sscanf(url, urlPattern, servername, path);
printf("servername: %s ,path: %s \n",servername,path);
memset(&hints, 0, sizeof hints);
hints.ai_family= AF_INET;
hints.ai_socktype= SOCK_STREAM;

int addr_lookup= getaddrinfo(servername , "http", &hints, &serveraddr);
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


sprintf(request,"GET /%s HTTP/1.1\r\nHost: %s\r\n\r\n",path,servername);

int byte_sent = send(sockfd,request, strlen(request), 0);
bzero(buffer,BUFFERSIZE);
int byte_received =recv(sockfd, buffer, BUFFERSIZE, 0);
if(byte_received <0){
perror("Error in reading");
exit(4);
}


int response;
 sscanf(buffer, "HTTP/1.%*[01] %d ", &response);

if(response != 200)
{
	printf("Error occured while receiving data from the server %d\n", response);
	exit(0);
} 
	 printf("HTTP/1.0 200 OK\n");


char *data;
data = strstr(buffer, "\r\n\r\n");
data =data+4;

char *fn;
fn=strrchr(urlPattern, '/');
if(strlen(fn)<2)
{
fn= "index.html";
}
else
{
fn=fn+1;
}
printf("Name of the File: %s\n", fn);

FILE *fp;
fp=fopen(fn, "w");
fwrite(data,byte_received,1,fp);

while((byte_received =recv(sockfd,buffer,1024,0)) > 0)
{
printf("Writing the data in to the file");
fwrite(buffer,byte_received,1,fp);
}

printf("Received from server: %s", buffer);
close(sockfd);
return 0;
}//end main function

