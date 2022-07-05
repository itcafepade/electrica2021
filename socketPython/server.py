import sys
import os
import socket
import time
import asyncio
import threading
import random
import decimal

PORT = int(os.environ.get("PORT", "25000"))
state = 0
init = True
timeSleep = 1

def handler(a,b=None):
    sys.exit(1)

def timeout(seconds, newState):
    global state
    time.sleep(seconds)
    state = newState
    print('New state: ', state)

def numeroRandom(minimum, maximum):
    return float(decimal.Decimal(random.randrange(minimum, maximum))/10)

def main():
    global state
    global timeout

    server = socket.socket()
    server.bind(("", PORT))
    server.listen(5)
    print("Server listening on port: {}".format(PORT))

    counter = 0

    if(counter == 0):
        print('Initial state: ', state)
        threading.Thread(target=timeout, args=[timeSleep, 206]).start()

    while True:
        if sys.platform == "win32":
            import win32api
            win32api.SetConsoleCtrlHandler(handler, True)

        client, addr = server.accept()
        # print("Accepted connection from: {}".format(addr))

        counter += 1
        command = str(client.recv(1024).decode().replace('\n', ''))

        print("Command: {}".format(command))

        if command == "10":
            client.send("OK".encode())
            client.close()

        elif command == "11":
            client.send("OK".encode())
            client.close()

        elif command == "12":
            client.send("OK".encode())
            client.close()
            state = 205 
            threading.Thread(target=timeout, args=[timeSleep, 204]).start()

        elif command == "13":
            client.send("OK".encode())
            client.close()
            state = 203 
            threading.Thread(target=timeout, args=[timeSleep, 202]).start()

        elif command == "14":
            client.send("OK".encode())
            client.close()
            state = 201 
            threading.Thread(target=timeout, args=[timeSleep, 200]).start()

        elif command == "20":
            client.send("9".encode())
            client.close()

        elif command == "21":
            client.send(str(numeroRandom(0,1000)).encode())
            client.close()

        elif command == "22":
            client.send(str(numeroRandom(0,1000)).encode())
            client.close()

        elif command == "23":
            client.send(str(numeroRandom(0,1000)).encode())
            client.close()

        elif command == "24":
            client.send('10.0'.encode())
            client.close()

        elif command == "25":
            client.send('0.01'.encode())
            client.close()

        elif command == "26":
            client.send('0.001'.encode())
            client.close()

        elif command == "50":
            client.send('35.5'.encode())

        elif command == "51":
            client.send('2.0'.encode())

        elif command == "52":
            client.send('0.015'.encode())

        elif command == "53":
            client.send('0.001'.encode())

        elif command == "100":
            client.send(str(state).encode())

        else:
            print('Función no implementada')

main()