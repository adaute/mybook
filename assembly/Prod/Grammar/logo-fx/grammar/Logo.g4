grammar Logo ; 

@header {		
  package logoparsing;
}

FLOAT : [0-9][0-9]*('.'[0-9]+)? ;

BOOLEAN : 'true' | 'false' ;

STRING : [a-zA-Z]+;

WS : [ \t\r\n]+ -> skip ;

programme :
 liste_procedure_def? liste_instructions  
;

liste_instructions :   
 (instruction)+    
;

instruction :
   'av' expr # av
 | 'td' expr # td 
 | 'tg' expr #tg
 | 'lc' #lc
 | 'bc' #bc
 | 've' #ve
 | 're' expr #re
 | 'fpos' expr expr #fpos
 | 'fcc' expr expr expr #fcc
 | 'repete' expr '[' liste_instructions ']' #repete
 | 'store' #store
 | 'move' #move
 | 'donne "'STRING expr #donne
 | 'if' expr_bool '['liste_instructions']' ('['liste_instructions']')? #if
 | 'tantque' expr_bool '['liste_instructions']'  #while
 | calling_procedure #procedure
; 

liste_procedure_def :
 (procedure_def)+
;

procedure_def :
  'pour' STRING liste_arguments? (liste_instructions)? ('rends' expr)? 'fin' #pour
;

calling_procedure :
	STRING '['(expr)*']'
;

calling_fonction :
	STRING '['(expr)*']'
;

expr :
   FLOAT         # float
 | '(' expr ')'  # parenthese 
 | expr ('*' | '/') expr #mult
 | expr ('+' | '-') expr #sum
 | 'hasard' expr #hasard
 | 'cos' expr #cos
 | 'sin' expr #sin
 | 'loop' #loop
 | ':'STRING #variable
 | calling_fonction #fonction
;

expr_bool :
  BOOLEAN #bool
 | expr ('<' | '>' | '<=' | '>=' | '=' | '<>')  expr #operation_bool
;

liste_arguments :
	(':'STRING)+
;


