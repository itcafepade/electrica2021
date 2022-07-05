import asyncio
import sys

srvIP = '192.168.1.2'
srvPort = 25000
routeFile = 'C://Users/Leonel/Proyectos/'
command = str(sys.argv[1])  #Ex: 51
value = str(sys.argv[2])  #Ex: 2.0
env = str(sys.argv[3]) #Ex: dev o production

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
    # return data
    exit(0)

   
def createFile(filename, data):
    f = open(filename, "w+")
    f.write(data)
    f.close()

async def asignData(testValue = -1):
    if env == "production":
        data = await tcp_echo_client(command+'\n')
        if value != "-1":
            newValue = await tcp_echo_client(value+'\n')
            data = newValue
    else:
        data = testValue

    # createFile(command+'.txt', str(data))

    return data

async def readData(testValue = -1):
    if env == "production":
        data = await tcp_echo_client(command+'\n')
    else:
        data = testValue

    # createFile(command+'.txt', str(data))

    return data

asyncio.run(main())