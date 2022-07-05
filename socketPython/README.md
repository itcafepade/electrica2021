Python Socket Example
=====================

This example chute demonstrates a server that listens on a TCP socket.

Instructions
------------

Clone this repository to your development machine.

    git clone https://github.com/ParadropLabs/python-socket-example
    cd python-socket-example

Install the chute on a Paradrop node.

    pdtools node --target <node IP address> install-chute

Test the server using the included client code.

    python2 client.py <node IP address> 8081
