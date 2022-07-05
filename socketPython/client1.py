import socket
import sys

if __name__ == "__main__":
    client = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    client.connect(('192.168.1.2', 25000))
    message = client.recv(1024)
    print(message)
    exit(0)