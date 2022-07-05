import asyncio
import sys
import time

srvIP = '192.168.1.3'
srvPort = 25000
command = str(sys.argv[1])  #Ex: 51
value = str(sys.argv[2])  #Ex: 2.0

async def tcp_echo_client(message):
    reader, writer = await asyncio.open_connection(
        srvIP, srvPort)

    print(message.replace('\n', ''))
    writer.write(message.encode())

    data = await reader.read(100)
    print(data.decode())

    # print('Cerrando la conexion')
    writer.close()

    return data.decode()

#Función a ejecutar al iniciar el script
async def main():
    data = await tcp_echo_client(command+'\n')
    if value != "-1":
        newValue = await tcp_echo_client(value+'\n')
        data = newValue
    
    exit(0)

asyncio.run(main())