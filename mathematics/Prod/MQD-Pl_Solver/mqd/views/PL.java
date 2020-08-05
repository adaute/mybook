package views;

import java.util.*;
import javax.swing.*;
import javax.swing.event .*;
import java.awt.*;
import java.awt.event.*;
import java.awt.Component;
import org.apache.commons.math3.fraction.BigFraction;
import models.Model;

@SuppressWarnings("rawtypes")

public class PL extends JPanel{
	public static boolean isMaximizing=true;
	private static final int textFieldSize=3;
	public int numOfIndependentVar;
    public int numOfConstraints;
    public Model model;

	private String varName="x";
	
	ArrayList<JLabel> labels;

	private GridBagConstraints gridBag;
	private static String[] dropMinMax={"MAX","MIN"};

	//	2264 er unicode for <=, 2265 for >=
	private String[] dropEquals={""+'\u2264',"=",""+'\u2265'};

	static JComboBox<String> dropDown;
	static JTextField inputObjectFunc[];
	static JTextField inputConstraintVec[];
	static JTextField inputConstraintMatrix[][];
    static JComboBox[] constraintEq;

    //	vars Tableau simplex
	static String topVector[];
	static String leftVector[];
	static BigFraction constraintMatrix[][];
	static BigFraction constraintVec[];
	static BigFraction objectFunc[];
	static BigFraction value;
	
	public PL(Model model) {

		this.model = model;

        numOfIndependentVar = model.getNumOfIndependentVar();
        numOfConstraints = model.getNumOfConstraints();

		setLayout(new GridBagLayout());
				
		gridBag = new GridBagConstraints();
		
		gridBag.gridx=1;
		gridBag.gridy=1;
		gridBag.gridwidth=1;
		gridBag.gridheight=1;
		gridBag.weightx=50;
		gridBag.weighty=10;
		gridBag.insets= new Insets(5,5,5,5);
		gridBag.anchor = GridBagConstraints.CENTER;
		gridBag.fill = GridBagConstraints.HORIZONTAL;

        // Label fonction objectif:
		gridBag.gridwidth=20;
	    add(new JLabel("Fonction objectif:"),gridBag);
		gridBag.gridwidth=2;

		dropDown = new JComboBox<String>(dropMinMax);

        // box Max Min PL
		gridBag.gridy=2;
		add(dropDown,gridBag);
		gridBag.gridwidth=1;
		gridBag.gridx+=1;

		//Nombres de variables
		inputObjectFunc = new JTextField[numOfIndependentVar];

		for(int i=0;i<inputObjectFunc.length;i++){
			inputObjectFunc[i]= new JTextField("0");
			inputObjectFunc[i].setColumns(textFieldSize);
			inputObjectFunc[i].setHorizontalAlignment(JTextField.CENTER);
			inputObjectFunc[i].addFocusListener(new ListenForFocus());
		}

		  labels = new ArrayList<JLabel>();

		for(int i=0;i<inputObjectFunc.length;i++){
			gridBag.gridx+=1;
			add(inputObjectFunc[i],gridBag);
			gridBag.gridx+=1;
			if(i!=inputObjectFunc.length-1){
				labels.add(new JLabel(varName + String.valueOf(i+1) + " +"));
			} else {
				labels.add(new JLabel(varName + String.valueOf(i+1)));		
			}
			 add(labels.get(labels.size()-1),gridBag);
		}

		// les contraintes
		inputConstraintVec = new JTextField[numOfConstraints];
		constraintEq = new JComboBox[numOfConstraints];

		for(int i=0;i<inputConstraintVec.length;i++){
			inputConstraintVec[i]= new JTextField("0");
			inputConstraintVec[i].setColumns(textFieldSize);
			inputConstraintVec[i].setHorizontalAlignment(JTextField.CENTER);
			inputConstraintVec[i].addFocusListener(new ListenForFocus());
			constraintEq[i]= new JComboBox(dropEquals);
		}

		inputConstraintMatrix =  new JTextField[numOfConstraints][numOfIndependentVar];
		for(int i=0;i<numOfConstraints;i++){
			for(int j=0;j<numOfIndependentVar;j++){
				inputConstraintMatrix[i][j] = new JTextField("0");
				inputConstraintMatrix[i][j].setColumns(textFieldSize);
				inputConstraintMatrix[i][j].setHorizontalAlignment(JTextField.CENTER);
				inputConstraintMatrix[i][j].addFocusListener(new ListenForFocus());
			}
		}

		gridBag.gridx=1;
		gridBag.gridy+=1;
		gridBag.gridwidth=20;
		add(new JLabel("Les contraintes:"),gridBag);
		gridBag.gridwidth=1;
		for(int i=0;i<inputConstraintVec.length;i++){
			gridBag.gridx=1;
			gridBag.gridy+=1;
			for(int j=0;j<numOfIndependentVar;j++){
				add(inputConstraintMatrix[i][j],gridBag);
				gridBag.gridx+=1;
				if(j!=numOfIndependentVar-1){
					labels.add(new JLabel(varName + String.valueOf(j+1)+ " +"));
				} else {
					labels.add(new JLabel(varName + String.valueOf(j+1)));
				}
				add(labels.get(labels.size()-1),gridBag);
				gridBag.gridx+=1;
			}
			
			//vecteur contrainte
			add(constraintEq[i],gridBag);
			gridBag.gridx+=1;
			add(inputConstraintVec[i],gridBag);
		}

					
    }

	public class ListenForFocus extends FocusAdapter{

		@Override
		public void focusGained(FocusEvent e) {
			Component comp = e.getComponent();
			if(comp instanceof JTextField){
				((JTextField) comp).setText("");
			}
		}

		@Override
		public void focusLost(FocusEvent e) {
			Component comp = e.getComponent();
			if(comp instanceof JTextField && ((JTextField) comp).getText().equals("")){
					((JTextField) comp).setText("0");
			}
		}
	}

	// fonction permettant de transformer notre PL de forme standard sous forme canonique
    public void convertToSimplex(Model model){
    	numOfIndependentVar = model.getNumOfIndependentVar();
        numOfConstraints = model.getNumOfConstraints();

        // Initialiser les variables
    	topVector = new String[0];
	    leftVector = new String[0];
	    constraintMatrix =new BigFraction[0][0];
	    constraintVec = new BigFraction[0];
	    objectFunc = new BigFraction[0];
	    value = new BigFraction(0);

	    // permet d'ajouter une contrainte si une contrainte comporte le signe =
    	for(int i=0;i<constraintEq.length;i++){
			if(constraintEq[i].getSelectedItem() == "="){
				numOfConstraints+=1;
			}
		}

		// si le choix est une MAX de pl
		if(dropDown.getSelectedItem() == "MAX"){

            // nombres de variables de notre PL
			topVector = new String[numOfIndependentVar];
			for(int i=0;i<topVector.length;i++){
				topVector[i]="x"+String.valueOf(i+1);
			}

            // nombres de contraintes de notre PL
			leftVector = new String[numOfConstraints];
			for(int i=0;i<leftVector.length;i++){
				leftVector[i]="y"+String.valueOf(i+1);
			}

            // init tab de contrainte (vec+matrice)
			constraintMatrix = new BigFraction[numOfConstraints][numOfIndependentVar];
			constraintVec = new BigFraction[numOfConstraints];

			{int i=0;
			int origIndex=0;

			while(i<numOfConstraints){
				if(constraintEq[origIndex].getSelectedItem()== "="){
					for(int j=0;j<numOfIndependentVar;j++){
						//	transformation en mutl par -1 la matrice
						constraintMatrix[i][j]=stringToFrac(inputConstraintMatrix[origIndex][j].getText());
						constraintMatrix[i+1][j]=stringToFrac(inputConstraintMatrix[origIndex][j].getText()).multiply(BigFraction.MINUS_ONE);
				    }
					
					// transformation en mutl par -1 le vecteur
					constraintVec[i]=stringToFrac(inputConstraintVec[origIndex].getText());
					constraintVec[i+1]=stringToFrac(inputConstraintVec[origIndex].getText()).multiply(BigFraction.MINUS_ONE);
					
					i+=2;
					origIndex+=1;
		        	
		        	// si nous devons inverser les signes
				} else if(constraintEq[origIndex].getSelectedItem()== ""+'\u2265'){
					for(int j=0;j<numOfIndependentVar;j++)
						constraintMatrix[i][j]=stringToFrac(inputConstraintMatrix[origIndex][j].getText()).multiply(BigFraction.MINUS_ONE);
					
					// transformation en mutl par -1 le vecteur
					constraintVec[i]=stringToFrac(inputConstraintVec[origIndex].getText()).multiply(BigFraction.MINUS_ONE);					
					
					i+=1;
					origIndex+=1;

				}  else {
				// Contrainte a ne pas inverser
					for(int j=0;j<numOfIndependentVar;j++)
						constraintMatrix[i][j]=stringToFrac(inputConstraintMatrix[origIndex][j].getText());
					
					constraintVec[i]=stringToFrac(inputConstraintVec[origIndex].getText());
					
					i+=1;
					origIndex+=1;
				}

	     	}}

	     	//fonction objectif
	     	objectFunc = new BigFraction[numOfIndependentVar];
			for(int i=0;i<inputObjectFunc.length;i++)
				objectFunc[i]=stringToFrac(inputObjectFunc[i].getText()).multiply(BigFraction.MINUS_ONE);

        } else {	     	//probleme de MIN

            // nombres de variables de notre PL
        	topVector = new String[numOfConstraints];
			for(int i=0;i<topVector.length;i++){
				topVector[i]="x"+String.valueOf(i+1);
			}
			
            // nombres de contraintes de notre PL
			leftVector = new String[numOfIndependentVar];
			for(int i=0;i<leftVector.length;i++){
				leftVector[i]="y"+String.valueOf(i+1);
			}

			constraintMatrix = new BigFraction[numOfIndependentVar][numOfConstraints];
			objectFunc = new BigFraction[numOfConstraints];

			{int i=0;
			int origIndex=0;

			while(i<numOfConstraints){
				if(constraintEq[origIndex].getSelectedItem()== "="){
					for(int j=0;j<numOfIndependentVar;j++){
						//	Transformation multiplication par -1
						constraintMatrix[j][i]=stringToFrac(inputConstraintMatrix[origIndex][j].getText());
						constraintMatrix[j][i+1]=stringToFrac(inputConstraintMatrix[origIndex][j].getText()).multiply(BigFraction.MINUS_ONE);
					}

					//Fonction objectif
					objectFunc[i]=stringToFrac(inputConstraintVec[origIndex].getText()).multiply(BigFraction.MINUS_ONE);
					objectFunc[i+1]=stringToFrac(inputConstraintVec[origIndex].getText());

					i+=2;
					origIndex+=1;

					// Inverser une contrainte
				} else if(constraintEq[origIndex].getSelectedItem()== ""+'\u2264'){
					for(int j=0;j<numOfIndependentVar;j++)
						constraintMatrix[j][i]=stringToFrac(inputConstraintMatrix[origIndex][j].getText()).multiply(BigFraction.MINUS_ONE);
					
					//Fonction objectif
					objectFunc[i]=stringToFrac(inputConstraintVec[origIndex].getText()).multiply(BigFraction.MINUS_ONE);					

					i+=1;
					origIndex+=1;

				} else {
					// Contrainte a ne pas inverser
					for(int j=0;j<numOfIndependentVar;j++)
						constraintMatrix[j][i]=stringToFrac(inputConstraintMatrix[origIndex][j].getText());

					//Fonction objectif
					objectFunc[i]=stringToFrac(inputConstraintVec[origIndex].getText()).multiply(BigFraction.MINUS_ONE);

					i+=1;
					origIndex+=1;
				}

			}}

			//	vecteur contraintes
			constraintVec = new BigFraction[numOfIndependentVar];
			for(int i=0;i<inputObjectFunc.length;i++)
				constraintVec[i]=stringToFrac(inputObjectFunc[i].getText());

        } 

        // maj du nombres de var et de contraintes
        model.setNumOfIndependentVar(topVector.length);
        model.setNumOfConstraints(leftVector.length);

    }

	// Function splitString
	public static String[] splitString(String input){
		String returnVal[] = {"",""};
		boolean hasFoundFrac=false;
		for(int i=0;i<input.length();i++){
			if(input.charAt(i)=='/'){
				hasFoundFrac=true;
			} else {
				if(hasFoundFrac){
					returnVal[1]+=input.charAt(i);
				} else {
					returnVal[0]+=input.charAt(i);
				}
			}
		}
		return returnVal;
	}

    	//	StringToFrac fonction
	public static BigFraction stringToFrac(String input){
		BigFraction res = BigFraction.ZERO;
		try{
			if(input.contains("/")){
				String frac[] = splitString(input);
				res = new BigFraction(Integer.parseInt(frac[0]),Integer.parseInt(frac[1]));
			} else if(input.contains(".")){
				res = new BigFraction(Double.parseDouble(input));
			} else {
				res = new BigFraction(Integer.parseInt(input));
			}
		} catch (NumberFormatException e){
			System.out.println("Format de nombre inconnu.\n(Code erreur: " + e + ")");
		}
		return res;
	}

	public static models.Matrix matrixConstructor(Model model){

		int row = 1+leftVector.length;
		int columm = 2+leftVector.length+topVector.length;

		models.Matrix matrix = new models.Matrix(row,columm);
			
		int k,w,x = 0,b = 0,a = 0;
        
        // fonction objectif dans matrice
        matrix.setElementAt(0,0, new models.Element(0,0,0));

		for(k= 1 ;k<columm;k++){
			if(k <= objectFunc.length )
			   matrix.setElementAt(0,k, new models.Element(0,k,Double.parseDouble(objectFunc[k-1].toString())));         
            else
               matrix.setElementAt(0,k, new models.Element(0,k,0));
		}

        int cpt = 0 ;

		// Les contraintes
		 for(w = 1 ;w < row ;w++){
		 	cpt = 0;
      	    for(k = 0 ;k <= topVector.length;k++){
      	    	if( k == 0){      	    	 
      	    	 matrix.setElementAt(w,k, new models.Element(w,k,Double.parseDouble(constraintVec[w-1].toString())));
                } else{
                  matrix.setElementAt(w,k, new models.Element(w,k,Double.parseDouble(constraintMatrix[w-1][cpt].toString())));
                  cpt++;
                }
		  }
		}

		// Les variables add
		for(w = 0 ;w < row ;w++){
      	    for(k = 0 ;k < columm-1 ;k++){
      	       if(w!=0 && ( (k-topVector.length)==w ) )       	    	 
      	         matrix.setElementAt(w,k, new models.Element(w,k,1));
		  }
		}

        matrix.setElementAt(0,columm-1, new models.Element(0,columm-1,0));

		 // fonction contraintes clonné en fin de tableau
		 for(w = 1 ;w < row ;w++)
      	   matrix.setElementAt(w,columm-1, new models.Element(w,columm-1,Double.parseDouble(constraintVec[w-1].toString())));

      	int nbrVarCpt=topVector.length;

		//ajout des noms des colonnes et lignes
		for(w = 0 ;w < row ;w++){
      	    for(k = 0 ;k < columm ;k++){
      	    	if(w == 0 ){
      	    		if(k == 0){
      	         	    matrix.getElementAt(w,k).setName("S");
      	    		}
      	         	else{
      	         		if(k != columm-1){
      	            	  matrix.getElementAt(w,k).setName("x"+(++x));
      	         		}
      	            	else{
      	         	      matrix.getElementAt(w,k).setName("Z");
      	            	}
      	         	}
      	    	}else{
      	    		 if(k != columm-1){ 
      	         if(k == 0){           	 
      	         	matrix.getElementAt(w,k).setName("b"+(++b));
      	         }
      	         else{
      	         	matrix.getElementAt(w,k).setName("a"+(++a));
      	         }
               } else{
               	 matrix.getElementAt(w,k).setName("x"+(++nbrVarCpt));
                }
      	    }
      	      
		  }
		}
		return matrix;
	}

}
