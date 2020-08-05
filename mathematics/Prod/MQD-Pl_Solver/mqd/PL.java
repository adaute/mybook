import java.util.*;
import javax.swing.*;
import javax.swing.event .*;
import java.awt.*;
import java.awt.event.*;
import java.awt.Component;
import org.apache.commons.math3.fraction.BigFraction;

@SuppressWarnings("serial")

public class PL extends JPanel{
	public static boolean isMaximizing=true;
	private static final int textFieldSize=3;
	public int numOfIndependentVar;
    public int numOfConstraints;

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
			constraintEq[i]= new JComboBox(dropEquals);
		}

		inputConstraintMatrix =  new JTextField[numOfConstraints][numOfIndependentVar];
		for(int i=0;i<numOfConstraints;i++){
			for(int j=0;j<numOfIndependentVar;j++){
				inputConstraintMatrix[i][j] = new JTextField("0");
				inputConstraintMatrix[i][j].setColumns(textFieldSize);
				inputConstraintMatrix[i][j].setHorizontalAlignment(JTextField.CENTER);
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
			//Drop-down og b-vektor
			add(constraintEq[i],gridBag);
			gridBag.gridx+=1;
			add(inputConstraintVec[i],gridBag);
		}

					
    }

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
	static BigFraction stringToFrac(String input){
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

	//	Fonction affichage du PL conv
	String printSimplex(){
		String res="\n\t";
		res+="---------Tableau simplex du PL -------\n\n\t";

		for(int i=0;i<topVector.length;i++){
			res+=topVector[i] + "\t";
		}
		res+="\n";

		for(int i=0;i<leftVector.length;i++){
			res+=leftVector[i] +"\t";
			for(int j=0;j<constraintMatrix[i].length;j++){
				res+=constraintMatrix[i][j].toString() + "\t";
			}
			res+=constraintVec[i].toString() + "\t";
			res+="\n";
		}

		res+="\t";
		for(int i=0;i<objectFunc.length;i++){
			res+=objectFunc[i].toString() + "\t";
		}
		res+=value.toString() + "\n";
		return res;
	}

}
