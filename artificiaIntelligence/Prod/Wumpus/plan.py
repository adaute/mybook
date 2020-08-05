import random
import copy

WIDTH_ = 4
HEIGHT_ = 4
GOALS_ = None
TARGET_ = (0, 0, 0)
WORLD_ = None
POS_ = (0, 0, 0)


def printList(l):
    for e in l: print(e)


def generateWorld(w, h):
    world = [["." for x in range(0, w)] for y in range(0, h)]
    obstacle = round(w * h / 3)
    for o in range(0, obstacle):
        world[random.randint(0, h - 1)][random.randint(0, w - 1)] = "X"
    world[0][0] = "."
    return world


def init(world, size, goals):
    global WORLD_
    global TARGET_
    global GOALS_
    global HEIGHT_
    global WIDTH_
    global POS_

    TARGET_ = goals[0]
    POS_ = (0, 0, 0)
    GOALS_ = goals
    WORLD_ = world
    HEIGHT_ = size
    WIDTH_ = size


def sortGoals(gls):
    copyGls = copy.deepcopy(gls)
    goals = []
    found = (0, 0, 0)
    pos = (0, 0, 0)
    while len(gls) > 0:
        found, s = search_with_parent(pos, gls, successeurs, profondeur_remove, profondeur_insert, None, False)
        if found:
            pos = (found[0], found[1], 0)
            gls.remove((found[0], found[1]))
            goals.append((found[0], found[1]))
        else:
            return copyGls
    return goals


def libre(x, y):
    return x in range(WIDTH_) and y in range(HEIGHT_) and ('W' not in (WORLD_[y][x])) and ('P' not in (WORLD_[y][x]))


def heuristique(position, target=TARGET_):
    return abs(target[0] - position[0]) + abs(target[1] - position[1])


def Aetoile(position, target=TARGET_):
    return heuristique(position, target) + position[2]


def successeurs(position):
    x = position[0]
    y = position[1]
    res = []
    for p in [(x - 1, y), (x + 1, y), (x, y - 1), (x, y + 1)]:
        if libre(p[0], p[1]): res.append(p)
    return res


def successeurs2(position):
    x, y, n = position
    n = n + 1
    res = []
    for p in [(x - 1, y, n), (x + 1, y, n), (x, y - 1, n), (x, y + 1, n)]:
        if libre(p[0], p[1]): res.append(p)
    return res


def search_m(s0, goals, succ, remove, insert, debug=False):
    l = [s0]
    save = [s0]
    while l:
        if debug: print("l = ", l, "\n")
        s, l = remove(l)
        if s in goals:
            return s
        else:
            for s2 in succ(s):
                if not s2 in save:
                    save.append(s2)
                    insert(s2, l)
    # print(save)
    return None


def search_with_parent(s0, goals, succ, remove, insert, h=None, debug=False):
    l = [s0]
    save = {s0: None}
    s = s0
    while l:
        if debug: print("l = ", l, "\n")
        s, l = remove(l)
        if (s[0], s[1]) in goals:
            return s, save
        else:
            for s2 in succ(s):
                if not s2 in save:
                    save[s2] = s
                    insert(s2, l)
                    if debug and h: print("h(" + str(s2[0]) + "," + str(s2[1]) + ") = " + str(h(s2)))
            if (h): l = sorted(l, key=lambda p: Aetoile(p))
    print(save)
    return None, save


def getPath(save, goal):
    pos = save[goal]
    path = [];
    path.insert(0, goal)
    while pos != None:
        path.insert(0, pos)
        pos = save[pos]
    return path[1:]


# sans mémoire

# largeur
def largeur_remove(l):
    return l.pop(0), l


def largeur_insert(s, l):
    l.append(s)
    return l


# profondeur
def profondeur_remove(l):
    return l.pop(0), l


def profondeur_insert(s, l):
    l.insert(0, s)
    return l


# return array concatenation
def merge(array):
    result = []
    for li in array:
        if li:
            for e in li:
                if e: result = result + [e]
    return result


# s = search(pos, goals, successeurs, largeur_remove, largeur_insert, True);

# s = search_with_parent(pos, goals, successeurs, largeur_remove, largeur_insert, True);
def find():
    global TARGET_
    global POS_
    global GOALS_
    full_path = []
    s = None
    found = False
    print(GOALS_)

    GOALS_ = sortGoals(GOALS_)
    GOALS_.append((0, 0))
    print("Goals list")
    print(GOALS_)
    for g in GOALS_:
        TARGET_ = g
        found, s = search_with_parent(POS_, [g], successeurs2, profondeur_remove, profondeur_insert, heuristique,
                                      False);
        POS_ = (found[0], found[1], 0)
        if found:
            # print(s)
            # print("\nWorld")
            # printList(WORLD_)
            print("found : (", found[0], found[1], ")")
            # print(s)
            # print("\nChemin")
            # print(s)
            full_path.append(getPath(s, found))
        else:
            print("Acun chemin trouvé")
            return None
    return merge(full_path)
