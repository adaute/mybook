# coding=utf-8
import os
import signal
import random
import sys
import subprocess
from datetime import datetime
import time
import matplotlib.pyplot as plt

from lib.gopherpysat import Gophersat
from lib.wumpus_client import WumpusWorldRemote
from requests.exceptions import HTTPError
from IA import *

import plan

# Ligne a remplacer avec VOTRE emplacement et nom de l'executable gophersat
# Attention ! Sous Windows, il faut remplacer les '\' par des '/' dans le chemin

# Random seed:
random.seed(datetime.now())

# Launching server
path = ".\lib\wumpus-server-win64-0.11.1-rc2.exe"
try:
    os.system("TASKKILL  /F /IM wumpus-server-win64-0.12.0-rc2.exe ")
except:
    print("server was not running")
process = subprocess.Popen(path, shell=True)

server = "http://lagrue.ninja:80"
#server = "http://localhost:8080"

groupe_id = "PRJ51"  # votre vrai numéro de groupe
names = "Evenson Jeunesse et Adrien Adrien"  # vos prénoms et noms

try:
    ww2 = WumpusWorldRemote(server, groupe_id, names)
except HTTPError as e:
    print(e)
    print("Try to close the server (Ctrl-C in terminal) and restart it")
    exit()

# lancer le jeu
while(1):
    player = IA(ww2)
    player.explore_alea()
    print("\nBILAN:\n")
    # print("Cost:"+ str(ww2.get_cost()))
    # print("Knowledge: "+str((ww2.get_knowledge())))
    # print("\nCarte finale: (knowledge + déductions)")
    brain = player.showBrain()
    # print(brain["map"])
    # print("\nFacts")
    # print(brain["facts"])

    phase, pos = ww2.get_status()
    print("status:", phase, pos)
    status, msg = ww2.end_map()
    print(status, msg)

    plan.init(brain["map"], brain["size"], brain["gold"])
    print("-" * 10)
    plan.printList(brain["map"])
    chemin = plan.find()
    player.run(chemin)
    print("-" * 10)
    print("COMPLETED")
    ww2.maze_completed()
    phase, pos = ww2.get_status()
    print("status:", phase, pos)
    print("TOTAL :", player.getTotalCost())

    print("\n\n" + "/" * 60 + "\n\n")
    # DEBUG
    # print(random.randint(0, 9))
    # print(ww.get_knowledge())
    # print(ww.probe(0, 2))
    # player.showWorld()
