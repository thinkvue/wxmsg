#!/usr/bin/env python3
# -*- coding: utf-8 -*-

"""
 :Author: lijian@midofa.com
 :URL: http://midofa.com
 :Date: 2020-01-15 16:50:40
 :LastEditors: lijian@midofa.com
 :LastEditTime: 2020-02-03 16:14:59
 :FilePath: \\Test\\test.py
 :Description: 唯一实例
"""

 
import threading
import socket
import os
import time

# 只运行唯一实例

class _reader(threading.Thread):

    def __init__(self, client):
        threading.Thread.__init__(self)
        self.client = client

    def run(self):
        while True:
            data = self.client.recv(1024)
            if data:
                string = bytes.decode(data, "utf-8", "ignore")
                # print(string)
            else:
                break

    def readline(self):
        rec = self.inputs.readline()
        if rec:
            string = bytes.decode(rec, "utf-8", "ignore")
            if len(string) > 2:
                string = string[0:-2]
            else:
                string = " "
        else:
            string = False
        return string


class _listener(threading.Thread):
    def __init__(self, port):
        threading.Thread.__init__(self)
        self.port = port
        self.sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        self.sock.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
        self.sock.bind(("0.0.0.0", port))
        self.sock.listen(0)

    def run(self):
        print("listener started")
        while True:
            client, cltadd = self.sock.accept()
            _reader(client).start()
            # print('client connect')



def _is_open(port):
    ip = "127.0.0.1"
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    try:
        s.connect((ip, int(port)))
        s.shutdown(2)
        return True
    except:
        return False


def start(port:int=50982):
    if _is_open(port):
        os._exit(0)
        return False
    else:
        lst = _listener(port)  # create a listen thread
        lst.start()
        return True


#测试
if __name__ == "__main__":
    start()
    print(1)
    # start()
    # print(2)
    time.sleep(555)
    print('over')
    # os._exit(0)
