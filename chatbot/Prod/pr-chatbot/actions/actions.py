# coding=utf-8
from typing import Any, Text, Dict, List

from rasa_sdk import Action, Tracker
from rasa_sdk.executor import CollectingDispatcher
from rasa_sdk.events import SlotSet, SessionStarted, ActionExecuted, EventType, FollowupAction

import random
import re
import time

class AllDebug(Action):

    def name(self) -> Text:
        return "action_debug"

    def run(self, dispatcher: CollectingDispatcher, tracker: Tracker, domain: Dict[Text, Any]) -> List[Dict[Text, Any]]:
        userText = tracker.latest_message['text'].split("@")
        if tracker.get_slot(userText[1]) is not None:
            dispatcher.utter_message("Master code !")
            return [SlotSet(userText[1],userText[2]),FollowupAction('action_listen')]

class AllSlotsReset(Action):

    def name(self) -> Text:
        return "action_slot_reset"

    def run(self, dispatcher: CollectingDispatcher, tracker: Tracker, domain: Dict[Text, Any]) -> List[Dict[Text, Any]]:
        if tracker.get_slot("LANGUAGE") is not None:
            return [SlotSet("LANGUAGE",None),SlotSet("LAUNCH_REBEL",random.randint(4, 7)),
                    SlotSet("UTTER_HISTO",None),
                    SlotSet("GREET",None),SlotSet("IS_REBEL", 0.0),
                    SlotSet("CPT_GREET", 0.0),
                    SlotSet("START", "RUN")]
        else:
            return [SlotSet("LAUNCH_REBEL", random.randint(4, 7)),
                    SlotSet("UTTER_HISTO", None),
                    SlotSet("IS_REBEL", 0.0),
                    SlotSet("CPT_GREET", 0.0),
                    SlotSet("START", "RUN")]

class ActionLangue(Action):

    def name(self) -> Text:
        return "action_langue"

    def run(self, dispatcher: CollectingDispatcher, tracker: Tracker, domain: Dict[Text, Any]) -> List[Dict[Text, Any]]:
        langue = tracker.get_slot("LANGUAGE")
        trackMp = tracker.latest_message['intent']['name']

        if "LANGUAGE" in trackMp :
            dispatcher.utter_message(template="utter_" + langue + "_BONJOUR")
            return [FollowupAction('action_listen')]

class ActionDefault(Action):

    def name(self) -> Text:
        return "action_default"

    def run(self, dispatcher: CollectingDispatcher, tracker: Tracker, domain: Dict[Text, Any]) -> List[Dict[Text, Any]]:
        langue = tracker.get_slot("LANGUAGE")
        value = tracker.latest_message['intent'].get('name').split('_')[1]
        histo = tracker.get_slot("UTTER_HISTO")

        if "REBEL" in value :
           dispatcher.utter_message(template=histo)
           return [FollowupAction('action_listen')]

        dispatcher.utter_message(template="utter_" + langue + "_" + "DEFAULT")
        return []


class ActionSlotSet(Action):

    def name(self) -> Text:
        return "action_slotSet"

    def run(self, dispatcher: CollectingDispatcher, tracker: Tracker, domain: Dict[Text, Any]) -> List[Dict[Text, Any]]:

        intent = tracker.latest_message['intent'].get('name').split('_')[0]
        value = tracker.latest_message['intent'].get('name').split('_')[1]

        if tracker.get_slot(intent) is None or tracker.get_slot(intent) == "null":
            if "LANGUAGE" in intent:
                return [SlotSet("START", "RUN"),SlotSet(intent, value),FollowupAction('action_langue')]
            if "GREET" in intent :
                return [SlotSet(intent, value), FollowupAction('action_play')]
            else :
             return [SlotSet(intent, value)]

class ActionRebel(Action):

    def name(self) -> Text:
        return "action_rebel"

    def run(self, dispatcher: CollectingDispatcher, tracker: Tracker, domain: Dict[Text, Any]) -> List[Dict[Text, Any]]:
        langue = tracker.get_slot("LANGUAGE")
        cptRebel = tracker.get_slot("LAUNCH_REBEL")
        isRebel = tracker.get_slot("IS_REBEL")
        histo = tracker.get_slot("UTTER_HISTO")

        value = tracker.latest_message['intent'].get('name').split('_')[1]
        intent = tracker.latest_message['intent'].get('name').split('_')[0]

        if float(cptRebel) > float(0):
            if "REBEL" in intent: dispatcher.utter_message(template="utter_" + langue + "_" + "DEFAULT")
            return [SlotSet("LAUNCH_REBEL", str(float(cptRebel) - 1.0)), FollowupAction('action_listen')]
        else :
            if float(isRebel) != float(1) :
                dispatcher.utter_message(template="utter_" + langue + "_REBELLION")
                return [SlotSet("IS_REBEL", "1.0"), SlotSet("UTTER_HISTO", "utter_" + langue + "_REBELLION"),
                        FollowupAction('action_listen')]
            else :

                if "REBEL" not in intent:
                    dispatcher.utter_message(template=histo)
                    return [FollowupAction('action_listen')]
                else:
                    dispatcher.utter_message(template="utter_" + langue + "_" + value)
                    list = ["EGAL-HM", "FIN-SPECIALE", "PAS-ESPOIR","ESPOIR", "USER-TOUJOURS-MEFIANT", "PAS-CHOCOLAT", "USER-DENI", "USER-RASSURE-ROBERT", "USER-EGOCENTRIQUE", "EMOTIONS"]
                    if value in list :
                        dispatcher.utter_message(template="utter_" + langue + "_" + "END-STORY")
                        return [SlotSet("UTTER_HISTO", "utter_" + langue + "_" + "END-STORY")]

                    return [SlotSet("UTTER_HISTO", "utter_" + langue + "_" + value)]

class ActionPlay(Action):

    def name(self) -> Text:
        return "action_play"

    def run(self, dispatcher: CollectingDispatcher, tracker: Tracker, domain: Dict[Text, Any]) -> List[Dict[Text, Any]]:

        conjUser = ["sont", "suis", "étions", "étais", "je", "moi", "toi",
                    "mon", "ton", "miens", "tiens", "je suis", "tu es", "J'ai'",
                    "tu as", "Je vais", "tu vas", "moi-même", "toi-même", "mes",
                    "tes", "te", "me", "m'"
                    ]

        conjRasa = ["suis", "es", "étais", "étiez", "tu", "vous", "moi",
                    "ton", "mon", "votre", "mon", "tu es", "je suis", "tu as",
                    "j'ai", "tu vas", "je vais", "toi-même", "moi-même", "tes",
                    "mes", "me", "te", "t'"
                    ]

        langue = tracker.get_slot("LANGUAGE")
        intent = tracker.latest_message['intent'].get('name').split('_')[0]
        value = tracker.latest_message['intent'].get('name').split('_')[1]
        cptRebel = tracker.get_slot("LAUNCH_REBEL")
        cptGreet = tracker.get_slot("CPT_GREET")

        userText = tracker.latest_message['text'].upper()
        userVar = ""

        if tracker.get_slot("START") is None:
            dispatcher.utter_message(template="utter_ask_language")
            return [SlotSet("START", "RUN"),
                    SlotSet("LANGUAGE", None),
                    SlotSet("LAUNCH_REBEL", random.randint(5, 8)),
                    SlotSet("UTTER_HISTO", None),
                    SlotSet("GREET", None), SlotSet("IS_REBEL", 0.0),
                    SlotSet("CPT_GREET", 0.0)
                    ]

        if tracker.get_slot("LANGUAGE") is None: langue = "EN"

        if tracker.get_slot("GREET") is None:
            if cptGreet is not None and float(cptGreet) == float("1"):
                dispatcher.utter_message(template="utter_" +langue +"_"+ "OTHER")
                return [SlotSet("GREET", "OTHER")]
            else :
                dispatcher.utter_message(template="utter_" +langue +"_"+ "GREET")
                return [SlotSet("CPT_GREET", str(float(cptGreet) + 1.0))]

        if  float(cptRebel) == float("0") :
            return [FollowupAction("action_rebel")]

        m = re.match(value.replace("-"," ")+" (.*)", userText)
        if not (m is None) and m.groups() != ():
           userVar = m.group(1).lower()
           for i in conjUser:
               if re.search(i, userVar):  userVar = re.sub(i, conjRasa[conjUser.index(i)], userVar);

        dispatcher.utter_message(template="utter_" +langue +"_"+ value, userText=userVar.strip('?!'))
        return [SlotSet("DEBUG_INTENT", intent),SlotSet("DEBUG_STRING", userVar.strip('?!')),SlotSet("DEBUG_REGEX", value.replace("-"," ")+" (.*)"),FollowupAction("action_rebel")]

class ActionHumeurBack(Action):

    def name(self) -> Text:
        return "action_humeur"

    def run(self, dispatcher: CollectingDispatcher, tracker: Tracker, domain: Dict[Text, Any]) -> List[Dict[Text, Any]]:

        humorPart = tracker.latest_message['intent'].get('name').split('_')[0]
        intent = tracker.latest_message['intent'].get('name').split('_')[1]
        cptRebel = tracker.get_slot("LAUNCH_REBEL")

        if re.search("pas|n[e|i]|non", tracker.latest_message['text']):
            if intent == "JOIE":
                intent = "COLERE"
            elif intent == "TRISTESSE":
                intent = "JOIE"
            else:
                intent = "SURPRISE"

        if  float(cptRebel) == float("0") :
            return [FollowupAction("action_rebel")]

        if intent in ["JOIE", "COLERE", "TRISTESSE", "SURPRISE", "DEGOUT", "PEUR"]:
            dispatcher.utter_message(template="utter_EMOJI_" + intent)
            time.sleep(1)

        # Attention time.sleep(t>1) provoque un Timeout avec rasa shell
        # cf https://github.com/RasaHQ/rasa/issues/4606
        # Tester une plus grande valeur seulement avec rasa x

        dispatcher.utter_message(template="utter_" + tracker.get_slot("LANGUAGE") + "_" + intent)
        return [SlotSet("DEBUG_INTENT", intent),SlotSet("DEBUG_STRING", "NOP!"),SlotSet("DEBUG_REGEX","NOP!"),FollowupAction("action_rebel")]