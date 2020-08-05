# coding=utf-8
def s(x):
    return str(x)


def l(x):
    return list(x)


def printList(l):
    for e in l:
        print(e)


# return array concatenation
def chain(array):
    result = []
    for li in array:
        if li:
            for e in li:
                if e: result = result + [e]
    return result


# Class de génération des différentes régles
class RulesGenerator():
    def __init__(self, width, height):
        self.width = width
        self.height = height
        self.KB = []
        self.voca = None
        self.run()

    def generateVocabulary(self, vars):
        result = []
        for var in vars:
            result += chain([[var + str(i) + str(j) for j in range(self.height)] for i in range(self.width)])
        return result

    # var is around position (i,j)
    def isOneAround(self, i, j, var):
        result = []
        if i + 1 < self.width:
            result.append(var + s(i + 1) + s(j))
        if i - 1 >= 0:
            result.append(var + s(i - 1) + s(j))
        if j + 1 < self.height:
            result.append(var + s(i) + s(j + 1))
        if j - 1 >= 0:
            result.append(var + s(i) + s(j - 1))
        return result

    # B is all around A
    def isAllAround(self, A, i, j, B):
        nA = "-" + A + str(i) + str(j)
        result = []
        if i + 1 < self.width:
            result.append([nA, B + s(i + 1) + s(j)])
        if i - 1 >= 0:
            result.append([nA, B + s(i - 1) + s(j)])
        if j + 1 < self.height:
            result.append([nA, B + s(i) + s(j + 1)])
        if j - 1 >= 0:
            result.append([nA, B + s(i) + s(j - 1)])
        return result

    # A is surrounded by B
    def isInner(self, A, i, j, B):
        nB = "-" + B
        result = [A + str(i) + str(j)]
        if i + 1 < self.width:
            result.append(nB + s(i + 1) + s(j))
        if i - 1 >= 0:
            result.append(nB + s(i - 1) + s(j))
        if j + 1 < self.height:
            result.append(nB + s(i) + s(j + 1))
        if j - 1 >= 0:
            result.append(nB + s(i) + s(j - 1))
        return result

    # implication : [A] -> [B] = [-A1,-A2,...,B1,B2,...]
    # ex : A and B and C or D -> F or G  = involve(["A B C","D"], ["F","G"])
    # result :
    # right side must be only OR connectors !!!!
    def involve(self, A, B):
        result = []
        for e in A:
            s = e.split()
            result.append(("-" + (" -".join(s))).split() + B)
        return result

    # if one case is type A cannot be type B and if it is type B it's not type A
    # ["A","B"]
    def exclusif(self, A, B):
        return chain(chain(
            [[self.involve([A + s(i) + s(j)], ["-" + B + s(i) + s(j)]) for j in range(0, self.height)] for i in
             range(0, self.width)]))

    # if var can be true only on one position.
    # it's false false for other positions
    def unique(self, var):
        result = []
        for x in range(self.width):
            for y in range(self.height):
                for i in range(x, self.width):
                    for j in range(y, self.height):
                        if i != x or j != y: result += self.involve([var + s(x) + s(y)], ["-" + var + s(i) + s(j)])
        return result

    # Lorsque l'on est sur une case il y a une propriété sur au moins une case autour
    # ex : A(i)(j) ->  B(i+1)(j) V B(i-1)(j) V B(i)(j+1) V B(i)(j-1)
    def rule1(self, A, B):
        return chain(chain(
            [[self.involve([A + s(i) + s(j)], self.isOneAround(i, j, B)) for j in range(self.height)] for i in
             range(self.width)]))

    # Reciproque rule1
    # Lorsqu'il il a la propriete sur au moins une case autour
    # ex :  B(i+1)(j) V B(i-1)(j) V B(i)(j+1) V B(i)(j-1) -> A(i)(j)
    def rule2(self, A, B):
        return chain(chain(
            [[self.involve(self.isOneAround(i, j, A), [B + s(i) + s(j)]) for j in range(self.height)] for i in
             range(self.width)]))

    # Lorsque l'on est sur une case il y a une même propriété sur toutes les cases autour
    # ex : A(i)(j) ->  B(i+1)(j) and B(i-1)(j) and B(i)(j+1) and B(i)(j-1)
    def rule4(self, A, B):
        return chain(
            chain([[self.isAllAround(A, i, j, B) for j in range(self.height)] for i in range(self.width)]))

    # Lorsque toutes les cases autour sont les mêmes (S,B) on peut en déduire la présence du wumpus ou d'un trou
    # ex :  B(i+1)(j) and B(i-1)(j) and B(i)(j+1) and B(i)(j-1) -> A(i)(j)
    def rule3(self, A, B):

        return chain(
            chain([[[self.isInner(A, i, j, B)] for j in range(1, self.height - 1)] for i in range(1, self.width - 1)]))

    def run(self):
        self.voca = self.generateVocabulary(["S", "W", "B", "P", "G"])
        self.KB = []

        # S(i)(j) ->  W(i+1)(j) V W(i-1)(j) V W(i)(j+1) V W(i)(j-1)
        self.KB += self.rule1("S", "W")
        # W(i+1)(j) V W(i-1)(j) V W(i)(j+1) V W(i)(j-1) -> S(i)(j)
        self.KB += self.rule2("W", "S")
        # S(i+1)(j) and S(i-1)(j) and S(i)(j+1) and S(i)(j-1) -> W(i)(j)
        self.KB += self.rule3("W", "S")
        # W(i)(j) ->  S(i+1)(j) V S(i-1)(j) V S(i)(j+1) V S(i)(j-1)
        self.KB += self.rule4("W", "S")

        # B(i)(j) ->  P(i+1)(j) V P(i-1)(j) V P(i)(j+1) V P(i)(j-1)
        self.KB += self.rule1("B", "P")

        # P(i+1)(j) V P(i-1)(j) V P(i)(j+1) V P(i)(j-1) -> B(i)(j)
        self.KB += self.rule2("P", "B")
        # P(i)(j) ->  B(i+1)(j) V B(i-1)(j) V B(i)(j+1) V B(i)(j-1)
        self.KB += self.rule4("P", "B")

        # B(i+1)(j) and B(i-1)(j) and B(i)(j+1) and B(i)(j-1) -> P(i)(j)
        # self.KB += self.rule3("P", "B")

        # une même case ne peux pas avoir ces 2 même valeurs
        self.KB += self.exclusif("S", "W")
        self.KB += self.exclusif("G", "W")
        self.KB += self.exclusif("G", "P")
        self.KB += self.exclusif("W", "P")

        # ces cases sont self.uniques dans le jeu
        self.KB += self.unique("W")
        self.KB += self.unique("G")

        # facts
        facts = [["-W00"], ["-P00"]]

        self.KB += facts

        # DEBUG :
        # print(voca)
        # printList(self.KB)
        # print(facts)
