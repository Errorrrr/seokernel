import subprocess
import time
import fcntl
import os
import requests
from sys import argv
import json
import sys, threading
sys.setrecursionlimit(10**7) # max depth of recursion
threading.stack_size(2**27)  # new thread will get stack of such size
allQueries = []

class Thread:
    num = ""
    isActive = False

    def __init__(self, num):
        self.num = num

    def setEnable(self):
        self.isActive = True

    def setDisable(self):
        self.isActive = False

class Process:
    process = None
    thread = None
    fileNum = None

    def startProcess(self,fileNum,thread):
        first, second, third = argv

        self.fileNum = fileNum
        self.process = subprocess.Popen(str(second)+' '+os.path.dirname(os.path.realpath(__file__))+'/artisan xml:thread ' + str(fileNum), executable='/bin/bash', shell=True, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
        print('Запущен процесс для номера потока:'+str(thread.num)+' и номера группы запросов №'+str(fileNum))
        self.thread = thread
        self.thread.setEnable()

    def offProcess(self):
        try:
            for line in self.process.stdout:
                       allQueries.append(json.loads(line.rstrip()))
        except ValueError:
            test = 1
        print('Закончилась работа для потока:'+str(self.thread.num)+' и номера группы запросов '+str(self.fileNum))
        self.thread.setDisable()

    def isProcessRunning(self):
        poll = self.process.poll()
        if poll is None:
            return True
        else:
            return False

class Processes:
    processes = []

    def startNewProcess(self, fileNum, thread):
        process = Process()
        process.startProcess(fileNum, thread)
        self.processes.append(process)

    def hasWorkingProcesses(self):
        for process in self.processes:
            if process.isProcessRunning():
                return True
        return False

    def updateProcesses(self):
        for process in self.processes:
            if not process.isProcessRunning():
                process.offProcess()
                self.processes.remove(process)

    def printAll(self):
        for process in self.processes:
            print(process.fileNum)


class Threads:
    threads = []

    def addThread(self, thread):
        self.threads.append(thread)

    def generateThreadsByList(self, threadList):
        for threadItem in threadList:
            thread = Thread(threadItem)
            self.addThread(thread)

    def getFreeThread(self):
        for thread in self.threads:
            if not thread.isActive:
                return thread
        return None

class Posts:
    posts = []

    def generatePosts(self, starNum, endNum):
        for i in list(range(starNum,endNum+1)):
            self.posts.append(str(i))

    def deletePost(self,postNum):
        self.posts.remove(postNum)

    def getPostNum(self):
        for i in self.posts:
            return i
        return None

def getThreadsList():
    result = []
    for item in range(0,150):
        result.append(item)
    return result



print("Начало работы скрипта")


isWorking = True

threadList = getThreadsList()

first, second, third = argv

print(third)
posts = Posts()
posts.generatePosts(0,int(third))


threads = Threads()
threads.generateThreadsByList(threadList)
processes = Processes()

i = 0
while(isWorking):
    i += 1
    time.sleep(0.01)
    if not threads.getFreeThread() is None and not posts.getPostNum() is None:
        postNum = posts.getPostNum()
        processes.startNewProcess(postNum, threads.getFreeThread())
        posts.deletePost(postNum)

    processes.updateProcesses()

    if not processes.hasWorkingProcesses() and posts.getPostNum() is None:
        print("Нет активных процессов, нет неразобранных запросов!")
        isWorking = False
    if i == 100:
        i = 0
        first, second, third = argv
        subprocess.Popen(str(second)+' '+os.path.dirname(os.path.realpath(__file__))+'/artisan update:progress ' + str(postNum), executable='/bin/bash', shell=True, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
        processes.printAll()

print(allQueries)
with open(os.path.dirname(os.path.realpath(__file__))+'/storage/app/result.json', 'w') as f:
    json.dump(allQueries, f, ensure_ascii=False)
