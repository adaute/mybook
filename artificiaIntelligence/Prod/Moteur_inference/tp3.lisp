; Author : Adrien Agnel
; Year : 2020
; UV : IA01


;CONSTANTES (produites à partir de notre expertise)

(setq *type_suspects* '((suspect homme)(suspect femme)(suspect femme_trompee)(suspect amant)(suspect amante)(suspect voleur)(suspect entourage)))
(setq *type_faits* '(arme blessures blessure_localisation circonstance couleur_corps type_crime effraction lieu_homicide origine trace_biologique victime indice))

(setq arme '(arme_blanche arme_a_feu objet_contendant lien mains_nues))
(setq blessures '(coupure par_balle morsure brulures fracture hematome invisibles))
(setq blessure_localisation '(cou poignet organes_sexuels organes_vitaux coeur))
(setq circonstance '(brule empoisonnement etranglement sabotage battu_a_mort coup_couteau_mortel tue_par_balle noyade))
(setq couleur_corps '(normale anormale))
(setq type_crime '(premedite non_premedite))
(setq effraction '(oui non))
(setq indice '(relation_sexuelle signes_lutte maitresse amant testament))
(setq lieu_homicide '(eau maison))
(setq origine '(vol vengeance altercation adultere))
(setq trace_biologique '(cheveux_longs liquide_seminal ADN_criminel_fiche))
(setq victime '(victime_Fortunee homme femme))

;Autres fonctions de services

(defun regle_appliquee (regle)
  (member regle *regles_deja_appliquees* :test #'equal)
  )

(defun type_fait (fait)
  (car fait)
  )

(defun valeur_fait (fait)
  (cadr fait)
  )


; Gestion des enquêtes dans un fichier

; test 1
(defun sauvegarder_fichier_enquetes (filename)
  (let (f (open filename))
    (dolist (e *enquetes*)
      (write-string (write-to-string (eval e)) f))
    (close f)
    ))

; test 2
(defun sauvegarder_fichier_enquetes (filename)
  (with-open-file (str filename
                     :direction :output
                     :if-exists :supersede
                       :if-does-not-exist :create)
    (dolist (e *enquetes*)
      (format str "~A~%" (eval e)))
))

; probléme de format du fichier posant un probléme de lecture

(defun charger_fichier_enquetes (filename)
  (let (
        (in (open filename :if-does-not-exist nil))
        lines
       )
    (when in
      (loop for line = (read-line in nil)
        while line do (push (read-from-string line) lines))
      (close in))
    (reverse lines)
    ))

(defun supprimer_enquete_system (e)
  (setf *enquetes* (remove e *enquetes*)))


(defun supprimer_fait_enquete (fait)
  (let* (
         (enquete (eval (id_enquete *enquete_courante*)))
         (faits (remove nil (map 'list #'(lambda (x) (if (not (equal x fait)) x)) (faits_enquete enquete))))
        )   
    (set (id_enquete enquete) (append *enquete_courante* faits))
    faits
    ))


(defun ajouter_fait_enquete (fait)
  (let* (
         (enquete (eval (id_enquete *enquete_courante*)))
         (faits (faits_enquete enquete))
         )
    (push fait faits)
    (set (id_enquete enquete) (append *enquete_courante* faits))
    faits
    ))


;LES FONCTIONS DE SERVICE POUR LES REGLES

(defun buts_regle (regle)
	(car (last (eval regle)))
)

(defun premisses_regle (regle)
	(cadr (eval regle))
  )

;FONCTIONS DE SERVICE POUR LES ENQUETES

(defun id_enquete (enquete)
	(car enquete)
)

(defun nom_enquete (enquete)
	(cadr enquete)
)

(defun faits_enquete (enquete)
	(cddr enquete)	
)

;FONCTIONS INTERACTION AVEC UTILISATEUR


;BASE D'EXEMPLES : ENQUETES
(setq *enquetes* '()) 


;Exemples d'exécution

;moteur avant
(setq E1 '(E1 "Un jour pas comme les autres" (victime homme)(origine adultere)(blessures invisibles)(couleur_corps anormale)))
(push 'E1 *enquetes*)

;VARIABLES GLOBALES

; permet de stocker la base de faits de notre enquête dans ce cas il s'agit des faits de enquête exemple n°1
(setq *base_faits* (faits_enquete (eval (car *enquetes*))))

; permet de retenir les règles deja appliquées lors de l'exécution des chaînages
(setq *regles_deja_appliquees* '())

; permet de stocker les informations de enquête en cours de résolution
(setq *enquete_courante* (list (car *enquetes*) (nom_enquete (eval (car *enquetes*)))))

;LISTE DE RÈGLES
(setq R1 '(R1 ((blessures coupure)) ((arme arme_blanche)) ) )
(setq R2 '(R2 ((blessures par_balles)) ((arme arme_a_feu)) ) )
(setq R3 '(R3 ((blessures morsure)) ((circonstance empoisonnement)) ) )
(setq R4 '(R4 ((blessures brulures)(couleur_corps anormales)) ((circonstance brule)) ) )
(setq R5 '(R5 ((blessures fracture)(blessure_localisation tete)) ((arme objet_contendant)) ) )
(setq R6 '(R6 ((blessures hematome)(blessure_localisation cou)) ((arme lien)) ) )
(setq R7 '(R7 ((blessures hematome)(blessure_localisation poignet)) ((arme lien)) ) )
(setq R8 '(R8 ((blessures invisibles)(couleur_corps anormale)) ((circonstance empoisonnement)) ) )
(setq R9 '(R9 ((blessures hematome)(couleur_corps anormale)(blessure_localisation cou)) ((circonstance etranglement)) ) )
(setq R10 '(R10 ((blessure_localisation organes_sexuels)) ((indice relation_sexuelle)) ) )
(setq R11 '(R11 ((blessures hematome)) ((indice signes_lutte)) ) )
(setq R12 '(R12 ((blessures coupures)) ((indice signes_lutte)) ) )
(setq R13 '(R13 ((circonstance sabotage)) ((type_crime premedite)) ) )
(setq R14 '(R14 ((circonstance empoisonnement)) ((type_crime premedite)) ) )
(setq R15 '(R15 ((circonstance battu_a_mort)) ((type_crime non_premedite)) ) )
(setq R16 '(R16 ((circonstance battu_a_mort)) ((suspect homme)) ) )
(setq R17 '(R17 ((circonstance etranglement)) ((suspect homme)) ) )
(setq R18 '(R18 ((circonstance coup_couteau_mortel)) ((suspect homme)) ) )
(setq R19 '(R19 ((circonstance tue_par_balle)(type_crime premedite)) ((suspect femme)) ) )
(setq R20 '(R20 ((circonstance tue_par_balle)(suspect amant)(victime homme)) ((suspect femme)) ) )
(setq R21 '(R21 ((circonstance tue_par_balle)) ((suspect homme)) ) ) 
(setq R22 '(R22 ((arme lien) (lieu_homicide eau) ) ((circonstance noyade)) ) )
(setq R23 '(R23 ((arme lien) (effraction oui) ) ((type_crime prémédité)) ) )
(setq R24 '(R24 ((arme mains_nues) (blessure_localisation cou) ) ((circonstance etranglement)) ) )
(setq R25 '(R25 ((arme arme_blanche) (blessure_localisation organes_vitaux) ) ((circonstance coup_couteau_mortel)) ) )
(setq R26 '(R26 ((arme arme_a_feu) (blessure_localisation coeur) ) ((circonstance tue_par_balle)) ) )
(setq R27 '(R27 ((arme objet_contendant)) ((suspect homme)) ) )
(setq R28 '(R28 ((arme mains_nues)) ((circonstance battu_a_mort)) ) )
(setq R29 '(R29 ((arme objet_contendant)) ((circonstance battu_a_mort)) ) )
(setq R30 '(R30 ((trace_biologique cheveux_longs)) ((suspect femme)) ) )
(setq R31 '(R31 ((trace_biologique liquide_seminal)) ((suspect homme)) ) )
(setq R32 '(R32 ((trace_biologique ADN_criminel_fiche)) ((suspect criminel_fiche)) ) )
(setq R33 '(R33 ((trace_biologique liquide_seminal)) ((indice relation_sexuelle)) ) )
(setq R34 '(R34 ((origine vol)(effraction oui)) ((suspect voleur)) ) )
(setq R35 '(R35 ((origine altercation)) ((type_crime non_premedite)) ) )
(setq R36 '(R36 ((origine adultere)(type_crime premedite)) ((suspect amant)) ) )
(setq R37 '(R37 ((type_crime premedite)(indice maitresse)) ((suspect femme_trompee)) ) )
(setq R38 '(R38 ((type_crime premedite)(effraction non)) ((suspect entourage)) ) )
(setq R39 '(R39 ((type_crime premedite)(effraction oui)) ((suspect voleur)) ) )
(setq R40 '(R40 ((type_crime premedite)(indice testament)) ((origine_crime heritage)) ) )
(setq R41 '(R41 ((suspect homme)(indice amant)) ((suspect homme_trompé)) ) )
(setq R42 '(R42 ((suspect femme)(indice maitresse)) ((suspect femme_trompee)) ) )
(setq R43 '(R43 ((suspect entourage)(circonstance non_battu_a_mort)(origine non_altercation )) ((type_crime premedite)) ) )
(setq R44 '(R44 ((suspect homme)(indice relation_sexuelle)(indice signes_lutte )) ((origine viol)) ) )
(setq R45 '(R45 ((victime victime_Fortunee)(lieu_homicide maison)(effraction oui )) ((suspect voleur)) ) )
(setq R46 '(R46 ((victime victime_Fortunee)(suspect entourage)) ((indice testament)) ) )

;Stocker l'ensemble des règles
(setq *regles* '(R1 R2 R3 R4 R5 R6 R7 R8 R9 R10 R11 R12 R13 R14 R15 R16 R17 R18 R19 R20 R21 R22 R23 R24 R25 R26 R27 R28 R29 R30 R31 R32 R33 R34 R35 R36 R37 R38 R39 R40 R41 R42 R43 R44 R45 R46))

; FONCTIONS : MOTEUR CHAINAGE AVANT EN PROFONDEUR

(defun obtenir_conflits ()
;pour chaque regle, si une regle est applicable alors elle appartient a la liste des conflits
  (let (liste_conflits)
    (dolist (r *regles*)
      (if (AND (not (member r *regles_deja_appliquees* :test #'equal)) (regle_applicable r))
        (push r liste_conflits)
      )	
      )
    liste_conflits
  )
)

(defun regle_applicable (regle)
;si une premisse n'est pas dans la base de fait alors la regle n'est pas applicable
  (let ((ok T))
    (dolist (p (premisses_regle regle))
     (if (not (member p *base_faits* :test #'equal)) (setq ok NIL)))
    ok
  )	
  )

(defun suspects_trouves ()
;pour chaque faits si l'attribut est égal à suspect alors on l'ajoute à la liste des suspects
	(let (suspects)
		(dolist (f *base_faits*)
			(if (eq (car f) 'suspect) (push (cadr f) suspects))			
		)
		suspects
	)
)


; pour chaque règle en conflit, on ajoute tous les buts qui ne sont pas déjà dans la base de faits à la base de faits
; Il faut que tous les faits (prémisses?) de la règle soient présents dans les faits pour ajouter le but dans la base des faits
(defun ajouter_conclusion (base_conflits)
  (dolist (regle base_conflits)
    (push regle *regles_deja_appliquees*)
    (dolist (x (buts_regle regle))
      (format t "~A ajouté~%" x)
      (pushnew x *base_faits*))
    ))


; LARGEUR : les règles sont toutes appliquées avant de reparcourir la bf à la recherche de nouveaux conflits
(defun moteur_avant ()
  (let ((clone_bf *base_faits*)(conflits (obtenir_conflits)))
    (if (not (null conflits))
        (progn
          (ajouter_conclusion conflits)
          (moteur_avant)
          )
      (progn
        (format t "~%IL N'Y A PLUS DE CONFLITS - TERMINÉ~%~%")
        (if (> (length (suspects_trouves)) 0)
            (progn
              (format t "Suspect(s) trouvé(s) : ~%")
              (dolist (s (suspects_trouves))
                (format t "~A~%" s)
                ))
          (format t "~%Désolé, aucun suspect potentiel ne ressort.~%"))
        (format t "~%==APPUYEZ SUR UNE TOUCHE POUR CONTINUER==~%")
        (read-line))
      )
    
    ;restauration de la base de fait initiale afin de ne pas interferer avec un test du second moteur
    (setq *base_faits* clone_bf)
    
    ; reset des règles déjà appliquées
    (setq *regles_deja_appliquees* '())
    ))


; CHAINAGE AVANT PROFONDEUR: les conflits sont ajoutés à une file d'attente, la première règle (selon l'ordre de la bf) est appliquée, on recherche les nouveaux conflits, etc...
; l'ordre des règles dépend de leur place dans la bf

(defun appliquer_regle (regle)
  (push regle *regles_deja_appliquees*)
  (dolist (x (buts_regle regle))
    (format t "~A ajouté~%" x)
    (pushnew x *base_faits*))
)
  
(defun moteur_avant_profondeur ()
  ; on récupère les conflits
  (let ((bf *base_faits*) (conflits (obtenir_conflits)))
    (if (not (null conflits))
      ; si règle trouvée
      (progn
        ;(format t "~A conflit(s) trouvé(s)~%" (length conflits))
        ;tant que des conflits existent, on applique la première règle
        (appliquer_regle (car conflits))
        (moteur_avant_profondeur)
      )
      ; si plus de règle applicable
      (let ((suspects (suspects_trouves)))
        (format t "~%TOUTES LES RÈGLES POSSIBLES ONT ÉTÉ UTILISÉES~%~%")
        (if (not (null suspects))
            ; Si au moins un suspect
            (progn
              (format t "Suspect(s) trouvé(s) :~%")
              (dolist (s suspects)
                (format t "~A~%" s)))
          ; Si aucun suspect trouvé
          (format t "Aucun suspect n'a été identifié.~%"))
        (format t "~%==APPUYEZ SUR UNE TOUCHE POUR CONTINUER==~%")
        (read-line)
      )
   )
   ; RESET
   (setq *base_faits* bf)
   (setq *regles_deja_appliquees* '())
  )
)


; MOTEUR D'INFÉRENCES EN CHAINAGE ARRIÈRE EN PROFONDEUR D'ABORD

(defun regles_ayant_pour_but (but)
; Renvoi la liste des règles concluant sur la liste des buts.
    (let (regles)
      (dolist (x *regles* (reverse regles))
        (if (member but (buts_regle  x) :test #'equal)
            (push x regles))
      )
    )
)

; v2
(defun chercher_but (but)
  (let ((ok (member but *base_faits* :test #'equal)))
  ; si le fait n'est pas connu, on recherche les règles qui y mènent
  (if (null ok)
      (dolist (r (regles_ayant_pour_but but)) ; recherche règles
        ; si une règle est validée, le but est trouvé
        (if (verifier_ET r)
            (progn
              (pushnew but *base_faits*)
              (format t "~A ajouté ~%" but)
              (setq ok t)
              t
              )
            )))
  ok
  ))

(defun verifier_ET (regle)
  (let ((premisses_ok t))
  ; on vérifie les premisses
  (dolist (p (premisses_regle regle))
    ; si tout est bon jusqu'ici, continuer à chercher les prémisses
    (if premisses_ok
        (setq premisses_ok (chercher_but p))
      ))
  ; (if (not (null premisses_ok)) (format t "Règle ~A validée ~%" regle))
  premisses_ok
))

(defun moteur_arriere ()
  (let ((saisie NIL)(bf *base_faits*))
    (format t "***** UTILISATION DU MOTEUR ARRIERE *****~%~%")
    (format t "Vous avez un doute sur un suspect ? Vérifier si les éléments de l'enquete permettent de coroborer ce doute !~%")
    (format t "~%** LISTE DES SUSPECTS POSSIBLES DANS LES ENQUETES EXPERTISÉES **~%~%")
    (dotimes (x (length *type_suspects*))
      (format t "~A - ~A~%" x (cadr (nth x *type_suspects*))))
    (loop 
      (format t "~%Choissez en tapant le numéro d'ordre du type de suspect à vérifier.~%")
      (setq saisie (read-line))
      (if (and
           (parse-integer saisie :JUNK-ALLOWED T)
           (< (parse-integer saisie) (length *type_suspects*))
           (>= (parse-integer saisie) 0)
          )
        (progn
            (if (chercher_but (nth (parse-integer saisie) *type_suspects*))
                (format t "~%Le système corobore. Certains indices vont dans le sens de votre hypothèse. Il est possible que ce soit le coupable~%~%")
                (format t "~%Le système de corobore pas. Vous suspectez peut-être le bon coupable mais aucun indice ne l'indique.~%~%"))
          
          ; RESET
          (format t "Voici les faits récoltés:~%")
          (dolist (f *base_faits*)
            (format t "~A~%" f))
          
          (format t "~%==APPUYEZ SUR UNE TOUCHE POUR CONTINUER==~%")
          (read-line)
          
          ; RESET
          (setq *base_faits* bf)
          (return-from NIL))
        
        (format t "ERREUR : Recommencez~%")
       ) ; end if
     ) ; end loop
))

;INTERFACE HOMME MACHINE (IHM)

(defun charger_enquetes () 
  (let (
        filename
        (defaut "~/enquetes.txt")
        lines
       )
    (format t "~%***** CHARGEMENT ENQUÊTES *****~%~%")
    (format t "Quel fichier voulez-vous charger (par défaut \"~A\") ?  " defaut)
    (setq filename (read-line))
    
    (if (equal filename "")
        (setq filename defaut))
    
    (setq lines (charger_fichier_enquetes filename))
    (if (not (null lines))
        (progn
          (format t "~%~%~A enquêtes ont été chargées depuis ~A~%~%" (length lines) filename)
          (setq *enquetes* '()) 
          (dolist (l lines)
            (push (id_enquete l) *enquetes*)
            (set (id_enquete l) l))
          )
      (format t "~%~%Erreur lors du chargement~%~%"))
    
    (format t "==APPUYEZ SUR UNE TOUCHE POUR CONTINUER==~%")
    (read-line)
    ))


(defun sauvegarder_fichier ()
  (let (
        filename
        (defaut "~/enquetes.txt")
        ok
       )
    (format t "~%***** SAUVEGARDER FICHIER *****~%~%")
    (format t "Dans quel fichier voulez-vous sauvegarder les enquetes (par défaut \"~A\") ?   " defaut)
    (setq filename (read-line))
    
    (if (equal filename "")
        (setq filename defaut))
    
    (setq ok (sauvegarder_fichier_enquetes filename))
    ;(if ok
        (format t "~%~%~A enquêtes ont été sauvegardées dans ~A~%~%" (length *enquetes*) filename)
      ;(format t "~%~%Erreur lors de la sauvegarde~%~%"))
    
    (format t "==APPUYEZ SUR UNE TOUCHE POUR CONTINUER==~%")
    (read-line)
  ))


(defun nouvelle_enquete ()
  (let (id)
    (format t "~%***** NOUVELLE ENQUÊTE *****~%~%")
    (setq id (gentemp "E"))
    (format t "Quel nom porte l'enquete ?  ")
    (set id (list id (read-line)))
    (push id *enquetes*)
    (setq *enquete_courante* (eval id))
    
    ; INIT
    (setq *base_faits* '())
    (setq *regles_deja_appliquees* '())
    
    (format t "~%Il vous faut maintenant ajouter des faits à la base~%~%")
    (format t "==APPUYEZ SUR UNE TOUCHE POUR CONTINUER==~%")
    (read-line)
    ))

(defun selection_enquete ()
  (let (saisie)	
    (format t "~%***** SÉLECTION D'UNE L'ENQUETE COURANTE *****~%")
    (set (id_enquete *enquete_courante*) (append *enquete_courante* *base_faits*))
    (format t  "~%***** LISTE DES ENQUETES *****~%")
    
    (dotimes (x (length *enquetes*))
      (format t "~A - ~A~%" x (nom_enquete (eval (nth x *enquetes*)))))
    
    (loop 
      (format t  "~%Choissez en tapant le numéro d'ordre de l'enquête~%~%")
      (setq saisie (read-line))
      
      (if (and
           (parse-integer saisie :JUNK-ALLOWED T)
           (< (parse-integer saisie) (length *enquetes*))
           (>= (parse-integer saisie) 0)
          )
          (progn
            (setq *enquete_courante* (eval (nth (parse-integer saisie) *enquetes*)))
            (setq *base_faits* (faits_enquete *enquete_courante*))
            (setq *enquete_courante* (list (car *enquete_courante*) (cadr *enquete_courante*))) ;evite d'avoir la BF courante en double
            (setq *regles_deja_appliquees* '())
            (return-from nil))
        (format t "ERREUR : Recommencez~%"))
      ) ; end loop
    ))

(defun sauvegarder_enquete ()
  (set (id_enquete *enquete_courante*) (append *enquete_courante* *base_faits*))
  (format t "Les modificatiosn apportées à l'enquete courante ont été sauvegardées.~%~%")
  (format t "==APPUYEZ SUR UNE TOUCHE POUR CONTINUER==~%")
  (read-line)
  )


(defun lister_faits ()
  (format t "~%***** LISTE DES FAITS DE L'ENQUETE COURANTE ****~%")
  (dolist (f *base_faits*)
    (format t "~A : ~A~%" (type_fait f) (valeur_fait f)))
  
  (format t "~%==APPUYEZ SUR UNE TOUCHE POUR CONTINUER==~%")
  (read-line))


(defun lister_enquetes ()
  (let (enquete)
  (format t "~%***** LISTE DES ENQUÊTES EXISTANTES ****~%")
    (doTIMES (x (length *enquetes*))
      (setq enquete (eval (nth x *enquetes*)))
      (format t "~A - ~A \"~A\" : ~A~%" x (id_enquete enquete) (nom_enquete enquete) (faits_enquete enquete)))
))

(defun supprimer_enquete ()
    (let (saisie enquete)
      (format t "~%***** SUPPRIMER UNE ENQUÊTE *****~%")
      (lister_enquetes)
      (format t "Q - pour quitter~%~%")
      
      (loop
        (format t "Entrer le numéro de l'enquête à supprimer :~%" )
        (setq saisie (read-line))
        
        (if (and
             (parse-integer saisie :JUNK-ALLOWED T)
             (< (parse-integer saisie) (length *enquetes*))
             (>= (parse-integer saisie) 0)
             )
            (progn ; si saisie valide
              (setq enquete (nth (parse-integer saisie) *enquetes*))
              
              (if (equal (id_enquete *enquete_courante*) enquete)
                  (format t "Vous ne pouvez pas supprimer l'enquête en cours~%")
                (progn ; si l'enquete peut être supprimée
                  (supprimer_enquete_system enquete)
                  (format t "~%**** L'enquête vient d'être supprimée ****~%~%")
                  (lister_enquetes)
                  (return-from nil))
              ))
          (if (or (equal saisie "q")(equal saisie "Q")) ; si la saisie n'est pas un nombre
              (return-from nil)
              (format t "Recommencez~%"))
        ))
))

(defun supprimer_fait ()
  (let* (
         (enquete (eval (id_enquete *enquete_courante*)))
         (faits (faits_enquete enquete))
         saisie
         fait
        )
    (format t "~%***** SUPPRIMER UN FAIT DE L'ENQUÊTE ~A *****~%~%" (id_enquete enquete))
    (format t "***** FAITS EXISTANT *****~%~%")
    (dotimes (x (length faits))
      (format t "~A - ~A~%" x (nth x faits)))
    (format t "Q - pour quitter~%~%")
    
    (loop
      (format t "Entrer le numéro du fait à supprimer de ~A:~%" (id_enquete enquete))
      (setq saisie (read-line))
      (if (and
           (parse-integer saisie :JUNK-ALLOWED T)
           (< (parse-integer saisie) (length faits))
           (>= (parse-integer saisie) 0))
          (progn
            (setq fait (nth (parse-integer saisie) faits))
            (setq *base_faits* (remove fait *base_faits*))
            (return-from nil))
        (if (or (equal saisie "q")(equal saisie "Q"))
            (return-from supprimer_fait)
          (format t "Recommencez~%"))
        ))
    (format t "~%**** Le fait vient d'être supprimé ****~%~%")
    (lister_faits)
  ))

(defun ajouter_fait ()
  (let (id (saisie NIL) type_fait valeur)
    (format t "~%***** AJOUTER UN FAIT DANS L'ENQUETE COURANTE *****~%~%")
    (format t "*** ETAPE 1 : CHOIX DU TYPE DE FAIT ***~%") 
    (dotimes (x (length *type_faits*))
      (format t "~A - ~A~%" x (nth x *type_faits*)))
    (loop 
      (format t "~%Choisissez le numéro de l'un des types de faits~%")
      (setq saisie (read-line))
      (if (and
           (parse-integer saisie :JUNK-ALLOWED T)
           (< (parse-integer saisie) (length *type_faits*))
           (>= (parse-integer saisie) 0))
          (progn
            (setq type_fait (nth (parse-integer saisie) *type_faits*))
            (return-from NIL))
        (format t "ERREUR : Recommencez~%")))
    
    (format t "~%*** ETAPE 2 : CHOIX DE LA VALEUR DU FAIT ***~%~%")
    
    (dotimes  (x (length (eval type_fait)))
      (format t "~A - ~A~%" x (nth x (eval type_fait))))
    
    (loop 
      (format t "~%Choisissez le numéro de l'une des valeurs possible pour le type de fait sélectionné~%")
      (setq saisie (read-line))
      (if (and
           (parse-integer saisie :JUNK-ALLOWED T)
           (< (parse-integer saisie) (length (eval type_fait)))
           (>= (parse-integer saisie) 0))
          (progn
            (setq valeur (nth (parse-integer saisie) (eval type_fait)))
            (return-from NIL))
        (format t "ERREUR : Recommencez~%")))
    
    (if (member (list type_fait valeur) *base_faits* :test #'equal)
        (progn
          (format t "~%**** Le fait existe déjà ****~%~%")
          (return-from ajouter_fait)))
      
      (push (list type_fait valeur) *base_faits*)
      (format t "~%**** Le fait vient d'être ajouté ****~%~%")
      (lister_faits)
    ))

(defun intro () ; Message d'introduction 
  (format t   "
                                
         .::::::::::.        --()====u         .::::::::::.
       .::::''''''::::.                      .::::''''''::::.
     .:::'          `::::....          ....::::'          `:::.
    .::'             `:::::::|        |:::::::'             `::.
   .::|               |::::::|_ ___ __|::::::|               |::.
   `--'               |::::::|_()__()_|::::::|               `--'
    :::               |::-o::|        |::o-::|               :::
    `::.             .|::::::|        |::::::|.             .::'
     `:::.          .::\-----'         `-----/::.          .:::'
       `::::......::::'                      `::::......::::'
         `::::::::::'                          `::::::::::'


~& ~& ~& ~
            Bonsoir enquêteur/enquêtrice, ~& ~&
            Un homicide a été commis ce soir... 
            Je suis là pour vous aider à trouver celui ou celle qui est le coupable.
            Justice sera rendu le coupable sera mis sous les barreaux !
            Afin de procéder à l'enquête veuillez entrer toutes les informations 
            que vous trouverez sur le lieu du crime 
            et je pourrais alors vous donner un ou plusieurs suspects ...~& 
			~& ~& ~& 

")

)

(defun main () ; Menu pour l'interaction avec l'utilisateur
  (let (saisie_utilisateur (separator "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~"))
    (loop
      (format t "~%### BIENVENUE SUR ENIGMA : SE DE RÉSOLUTIONS D'ENQUETES ###~%")
      (format t "~A ~%~%" separator)
      (format t "Nom de l'enquête courante : ~A~%" (nom_enquete *enquete_courante*))
      (format t "Nombre de faits présents en base : ~A~%" (length *base_faits*))
      (format t "~A ~%" separator )
      (format t "Pour charger les enquêtes depuis un fichier tapez B~%")
      (format t "Pour créer une nouvelle enquête tapez N~%")
      (format t "Pour supprimer une enquête tapez P~%")
      (format t "Pour sélectionner une enquête précédement saisie tapez S~%")
      ; (format t "Pour sauvegarder les enquêtes dans un fichier tapez T~%")
      (format t "~A ~%" separator)
      (format t "Pour ajouter un fait dans l'enquête en cours tapez I~%")
      (format t "Pour lister les faits dans l'enquête en cours tapez L~%")
      (format t "Pour supprimer un fait dans l'enquête en cours tapez D~%")
      (format t "Pour sauvegarder l'enquête courante tapez R~%")
      (format t "~A ~%" separator)
      (format t "Pour tenter d'élucider l'enquête sélectionnée avec le premier moteur d'inférence (chaînage avant largeur d'abord) tapez 1~%")
      (format t "Pour tenter d'élucider l'enquête sélectionnée avec le second moteur d'inférence (chaînage avant profondeur d'abord) tapez 2~%")
      (format t "Pour tenter d'élucider l'enquête sélectionnée avec le troisième moteur d'inférence (chaînage arrière) tapez 3~%")
      (format t "Pour quitter tapez Q~%")
      (format t "~A ~%~%" separator)
      
      (setq saisie_utilisateur (read-line))
      
      (case (read-from-string saisie_utilisateur)
        ((B b) (charger_enquetes))
        ((T t) (sauvegarder_fichier))
        ((N n) (nouvelle_enquete))
        ((S s) (selection_enquete))
        ((P p) (supprimer_enquete))
        ((R r) (sauvegarder_enquete))
        ((I i) (ajouter_fait))
        ((L l) (lister_faits))
        ((D d) (supprimer_fait))
        (1 (moteur_avant))
        (2 (moteur_avant_profondeur))
        (3 (moteur_arriere))
        ((Q q) (return-from main))
        (otherwise (format t "ERREUR : Recommencez~%~%")(main))
      )))
)

(intro)
(main)
