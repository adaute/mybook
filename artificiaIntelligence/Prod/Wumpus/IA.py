# coding=utf-8
import random
from datetime import datetime

from lib.gopherpysat import Gophersat

import rules

# Random seed:
random.seed(datetime.now())

# gophersat_exec = "C:/Users/DcEven/Datamatter/Cours/IA02/TP/wumpus/lib/gophersat/win64/gophersat-1.1.6"
gophersat_exec = "/Users/adrienadrien/Desktop/GI06/IA02/wumpus/lib/gophersat/macos64/gophersat-1.1.6"

# Variable de gestion de l'affichage (taille de la longueur de la console)
tw = 70


class IA:
    def __init__(self, world):
        self.size = 0
        self.world = world
        self.cost = 0
        # Récupération du labyrinthe
        status, msg, self.size = world.next_maze()
        if status != "[OK]":
            print(msg)
            exit()
        print(msg)
        print("taille: ", self.size)

        self.grid = [[[] for c in range(self.size)] for r in range(self.size)]
        self.unexplored = [(x, y) for x in range(self.size) for y in range(self.size)]
        self.next_probes = []  # position that should be visited in priority with a probe
        self.danger = []
        self.facts = []
        self.wumpus = False;
        self.gold_positions = []

        # Génération des régles du jeu Wunpus
        KB = rules.RulesGenerator(self.size, self.size)
        self.gs = Gophersat(gophersat_exec, KB.voca)
        for clause in KB.KB:
            self.gs.push_pretty_clause(clause)
        # print("To explore : ")
        # print(self.unexplored)
        # print("-" * tw)
        # self.showBrain()

    def showBrain(self):
        # Fonction permettant de montrer l'ensembles des connaissances que nous avons du plateau de jeu
        map = []
        for y in range(self.size):
            map.append([])
            for x in range(self.size):
                map[y].append("")
                for el in self.grid[y][x]:
                    if '-' not in el[0]: map[y][x] += el[0][0]
        return {"map": map, "facts": self.facts, "size": self.size, "gold": self.gold_positions}

    def add(self, x, y, clause, sure=False):
        # Permet d'ajouter une régle dans le KB si on est sur de la présence d'un ou des élements sur une case de jeu
        if x in range(self.size) and y in range(self.size):
            if clause not in self.grid[y][x]:
                self.grid[y][x].append(clause)
            if clause != "." and sure:
                if clause not in self.facts: self.facts.append(clause)
                self.gs.push_pretty_clause(clause)
                if not self.gs.solve():
                    self.gs.pop_clause()
                    self.facts.remove(clause)

    def getNextProbe(self):
        # ici on va essayer de privilégier le lancement de probe plutôt que des cautious_probe
        # print(self.next_probes)
        if len(self.next_probes) == 0:
            for x, y in self.unexplored:
                if self.guess(["W" + str(x) + str(y), "P" + str(x) + str(y)], x, y):
                    self.find("-W", x, y)
                    self.find("-P", x, y)
                    self.next_probes.append((x, y))
                if len(self.next_probes) > 10: break
        if len(self.next_probes) > 0:  # probe
            x, y = self.next_probes[0]
            self.next_probes.remove((x, y))
            return x, y, True;
        else:  # cautious probe
            x, y = self.unexplored[0]
            return x, y, False;

    def sendXProbe(self):
        # Envoyer une probe/cautious_probe pour sonder une case
        cost, status = (0, "")
        x, y, isprobe = self.getNextProbe()
        if isprobe:
            print("Sending Probe")
            status, percepts, cost = self.world.probe(y, x)
        else:
            print("Sending Cautious Probe")
            status, percepts, cost = self.world.cautious_probe(y, x)
        assert status == "[OK]", status
        self.unexplored.remove((x, y))
        self.cost += cost
        return {"x": x, "y": y, "clause": percepts}

    def explore_alea(self):
        # essayer de deviner ce qu'il y a autour de la position
        while len(self.unexplored) > 0:
            random.shuffle(self.unexplored)
            exp = self.sendXProbe()
            self.deduce(exp)
        print("cost : " + str(self.cost))
        return self.cost

    def explore_adjacent(self):
        # Parcourir la liste d'ajacent
        point = self.unexplored[0]
        x, y = point

        while len(self.unexplored) > 0:
            exp = self.sendXProbe(point)
            # print(exp)
            self.deduce(exp)
            # self.showBrain()
            # print(ww2)

            if len(self.unexplored) > 0:
                if (x + 1, y) in self.unexplored:
                    point = (x + 1, y)
                elif (x - 1, y) in self.unexplored:
                    point = (x - 1, y)
                elif (x, y - 1) in self.unexplored:
                    point = (x, y - 1)
                elif (x, y + 1) in self.unexplored:
                    point = (x, y + 1)
                else:
                    point = self.unexplored[0]
            # os.system("pause")

    def deduce(self, exp):
        # deduce permet en fonction d'un nouveau savoir de calculer des déductions logiques des élements
        # print("Deduce from : ")
        # print(exp)
        c = exp["clause"]
        x = exp["x"]
        y = exp["y"]

        if "W" in c:
            self.find("W", x, y, "S")
        else:
            self.find("-W", x, y)

        if "P" in c:
            self.find("P", x, y, "B")
        else:
            self.find("-P", x, y)

        if "S" in c:
            if not self.wumpus:
                self.fromClue("S", x, y, "W")
            else:
                self.find("S", x, y)
        else:
            self.find("-S", x, y, "-W")

        if "B" in c:
            self.fromClue("B", x, y, "P")
        else:
            self.find("-B", x, y, "-P")

        if "G" in c:
            self.gold(x, y)
        else:
            self.find("-G", x, y)

        if c == ".": self.grid[y][x].append(".")

    def guess(self, clause_neg, x, y):
        # Fonction qui retourne vrai si notre supposition est vraie, faux sinon
        if not (x in range(self.size) and y in range(self.size)): return False
        self.gs.push_pretty_clause(clause_neg)
        if not self.gs.solve():
            self.gs.pop_clause()
            # print("GS = UNSAT")
            return True
        self.gs.pop_clause()
        # print("GS = SAT")
        return False

    def find(self, A, x, y, around=None):
        # A has been found at x,y and A has <around> around it
        # print("Found : " + A + str(x) + str(y))
        self.add(x, y, [A + str(x) + str(y)], True)
        # dangerous position
        if around:
            for p in [(x - 1, y), (x + 1, y), (x, y - 1), (x, y + 1)]:
                self.add(p[0], p[1], [around + str(p[0]) + str(p[1])], True)

    def fromClue(self, A, x, y, near):
        # A has been found and we know that <near> is just near to A, lets try to guess.
        self.find(A, x, y)
        for x1, y1 in self.unknow_around(x, y):
            if self.guess(["-" + near + str(x1) + str(y1)], x1, y1):
                print(" Deduce : " + near + str(x1) + str(y1))
                self.find(near, x1, y1, A)
                if near is "W":
                    self.wumpus_found(x1, y1)
                elif near is "P":
                    self.pit_found(x1, y1)
                self.unexplored.remove((x1, y1))
                # remplacer par position trouvéé

    def unknow_around(self, x, y):
        res = []
        for p in [(x - 1, y), (x + 1, y), (x, y - 1), (x, y + 1)]:
            if (p[0], p[1]) in self.unexplored: res.append(p)
        return res

    def gold(self, x, y):
        # Si on trouve de l'or
        self.add(x, y, ["G" + str(x) + str(y)])
        if ["W" + str(x) + str(y)] not in self.grid[y][x]:
            self.gold_positions.append((x, y))
        # print(" Treasure found at : ", end=" ")
        # print(str(x) + str(y))

    def wumpus_found(self, x, y):
        self.wumpus = True;
        status, msg, cost = self.world.know_wumpus(y, x)
        assert status == "[OK]", msg
        for x, y in self.unexplored:
            self.add(x, y, ["-W" + str(x) + str(y)], True)

    def pit_found(self, x, y):
        status, msg, cost = self.world.know_pit(y, x)
        assert status == "[OK]", msg

    def follow(self, path):
        print("Following : ")
        print(path)
        for p in path:
            status, msg, cost = self.world.go_to(p[1], p[0])  # ! (y,x)
            print(msg)
            self.cost += cost
            if status != "[OK]": return False
        return True

    def run(self, path):
        if path and self.follow(path): return True
        return False

    def getTotalCost(self):
        return self.cost
