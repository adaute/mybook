
import java.text.DecimalFormat;

public class SimplexeIteration {
	
		
	private int variablesNumber=0,constraintsNumber=0;
	private Element pivot,incomingVariable,comingoutVariable;
	private Matrix matrix,result;
	private boolean cycle= false;
	private int iterationNumber = 0 ;
	

	public SimplexeIteration(Matrix matrix,int variablesNumber,int constraintsNumber){
		
		this.setNumbers(variablesNumber, constraintsNumber);		
		if(matrix!=null && matrix.getRowCount()==(1+constraintsNumber) && matrix.getColumnCount()==(2+variablesNumber+constraintsNumber)){
			this.matrix.copy(matrix);			
		}	    
	}
	
	public SimplexeIteration(int variablesNumber,int constraintsNumber){
		this(null,variablesNumber,constraintsNumber);
	}
	
	public int getVaraiblesNumber(){
		return this.variablesNumber;
	}
	
	public int getConstraintsNumber(){
		return this.constraintsNumber;
	}
	
	public Matrix getInitialMatrix() { return this.matrix; }
	
	public Matrix getResultMatrix() { return this.result; }
	
	public void setNumbers(int variablesNumber,int constraintsNumber){
		
		if(variablesNumber< 1 || constraintsNumber< 1){
			this.variablesNumber = 0;
			this.constraintsNumber = 0;
			this.matrix = new Matrix();			
		}else{
			
			this.variablesNumber = variablesNumber;
			this.constraintsNumber = constraintsNumber;
			this.matrix = new Matrix((1+constraintsNumber),(2+variablesNumber+constraintsNumber));			
		}		
		this.result = new Matrix();
		this.pivot = new Element(-1,-1,"Pivot");
		this.incomingVariable = new Element(-1,-1);
		this.comingoutVariable = new Element(-1,-1);
	}
	
	
	public void setIterationNumber(int iterationNumber){
		this.iterationNumber = iterationNumber ;
	}
	
	public int getIterationNumber(){
		return this.iterationNumber;
	}
	
	public boolean isInfiniteLoop() {
		return this.cycle;
	}
	
	public boolean isUnlimitedFunction() {
		if(pivot==null) return false;
		if(pivot.getColumn()==-1) return false;
		int i; 
		for(i=1;i<this.matrix.getRowCount();i++)
			if(matrix.getValueAt(i, pivot.getColumn())>0) return false;		
		return true;
	}
	
	
	private boolean isOptimal(Matrix m) {
		
		if(m==null || m.isEmpty()) return false;		
		int j;
		for(j=1;j<m.getColumnCount();j++)
			if(m.getValueAt(0,j)<0) return false;
		return true;
	}
	
	public boolean isOptimalSolution(){
		return this.isOptimal(this.result);
	}
	
	public boolean isOptimalMatrix() {
		return this.isOptimal(this.matrix);
	}
	
	public Element getPivot() { return this.pivot; }
	
		
	private void  selectIncomingBasisVariable(){
		int j;
		for(j=1;j<this.matrix.getColumnCount();j++){
			if(this.matrix.getValueAt(0,j)<0){
				if(pivot.getColumn()==-1){
					pivot.setColumn(j);
				}else{					
					if(Math.abs(this.matrix.getValueAt(0,j))>Math.abs(this.matrix.getValueAt(0, pivot.getColumn()))){
						pivot.setColumn(j);
					}
				}
			}
		}
	}
	
	private void selectComingoutBasisVariable() {		
		
		if(pivot.getColumn()!=-1) {
			
			int i,count=0;			
			for(i=1;i<matrix.getRowCount();i++){
			
				if(this.matrix.getValueAt(i, pivot.getColumn())>0){
				
					if(pivot.getRow()==-1) { pivot.setRow(i); count = 0; }
					else{
						
						Matrix r1 = new Matrix(1,matrix.getColumnCount());
						r1.copyRowValues(matrix.getRow(pivot.getRow()), 0);
						r1.multiplyRow(0, (double)1/matrix.getValueAt(pivot.getRow(), pivot.getColumn()));
						
						Matrix r2 = new Matrix(1,matrix.getColumnCount());
						r2.copyRowValues(matrix.getRow(i), 0);
						r2.multiplyRow(0, (double)1/matrix.getValueAt(i, pivot.getColumn()));
						
						int compare = r1.compareRowValues(0, r2.getRow(0));
						
						if(compare==0) count++;
						else if(compare>0) pivot.setRow(i);
					}
				}
			}			
			if(count>0)	{ this.cycle = true; pivot.setRow(-1); pivot.setColumn(-1); }
			else if(pivot.getRow()!=-1) pivot.setValue(matrix.getValueAt(pivot.getRow(), pivot.getColumn()));
		}		
	}
	
	private void computeRealizableBasisSolution() {
		
		if(pivot.getRow()!=-1 && pivot.getColumn()!=-1){
			int i ;
			
			result.setDimension(matrix.getRowCount(),matrix.getColumnCount());
			result.copy(matrix);			
			
			result.multiplyRow(pivot.getRow(),(double) 1/pivot.getValue());
			
			for(i=0;i<result.getRowCount();i++){				
				
				if(i==pivot.getRow()) continue;
				
				Matrix row = new Matrix(1,result.getColumnCount());
				row.copyRowValues(result.getRow(pivot.getRow()),0);				
				row.multiplyRow(0,(-1)*result.getValueAt(i,pivot.getColumn()));
				result.addRow(i, row.getRow(0));
			}
			
		    incomingVariable.setElement(result.getElementAt(0, pivot.getColumn()));
		    comingoutVariable.setElement(result.getElementAt(pivot.getRow(), result.getColumnCount()-1));
		    result.getElementAt(pivot.getRow(), result.getColumnCount()-1).setName(result.getElementAt(0,pivot.getColumn()).getName());
		    
		}
	}	
	
	public void applySimplexe() {
		
		pivot.setElement(null);
		pivot.setName("Pivot");		
		incomingVariable.setElement(null);
		comingoutVariable.setElement(null);		
		this.cycle = false ;
		result.clear();
		
		if(!this.isOptimalMatrix()){
			this.selectIncomingBasisVariable();
			if(!this.isUnlimitedFunction()){
				this.selectComingoutBasisVariable();
				if(!this.isInfiniteLoop()){
					this.computeRealizableBasisSolution();
				}
			}
		}
	}
		
	public String toString() {
		String valeur = "\nIteration "+this.getIterationNumber()+"\n\n";
		int i,j;
		DecimalFormat nombre = new DecimalFormat("0.00");
		valeur+="-- Problexec_complex_commandme de Programmation Lineaire a resoudre\n\n";		
		if(!this.matrix.isEmpty()){
			matrix.displayLastColumn(false);			
			valeur+= "   Max "+matrix.getElementAt(0,matrix.getColumnCount()-1).getName()+" = ";
			for(j=1;j<matrix.getColumnCount()-1;j++){
				
				if(matrix.getValueAt(0,j)==0) continue;
				if(j!=1) valeur+=" + " ;
				valeur+= "("+nombre.format((-1)*matrix.getValueAt(0,j))+")"+matrix.getElementAt(0,j).getName();				
				
			}
			valeur+=" \n" ;
			valeur+="   Sujet a : \n";
			for(i=1;i<matrix.getRowCount();i++){
				
				valeur+="      ";
				for(j=1;j<matrix.getColumnCount()-1;j++){
					
					if(matrix.getValueAt(0,j)==0) continue;					
					if(j!=1) valeur+=" + " ;
					valeur+= "("+nombre.format(matrix.getValueAt(i,j))+")"+matrix.getElementAt(0,j).getName();					
					
				}
				valeur+=" <= "+matrix.getValueAt(i,0)+" \n" ;
			}
			
			valeur+="         ";
			for(j=1;j<=this.variablesNumber;j++){
				valeur+=matrix.getElementAt(0,j).getName();
				if(j!=this.variablesNumber) valeur+=", ";
				else valeur+=" >= 0 \n\n";
			}
			
			valeur+="-- Tableau simplex Initiale.\n\n" ;
			valeur+= matrix+"\n\n";
			
		}else valeur+="  [Tableau  Simplexe Initial Vide]\n\n";
		
		
		valeur+="-- Tableau Simplexe Solution.\n\n";
		if(!this.result.isEmpty()){		
			result.displayLastColumn(false);
			valeur+=result+"\n\n";
			valeur+="-- Resume Iteration "+this.iterationNumber+".\n\n";
			valeur+="   Solution de base realisable : " ;
			valeur+="\n";
			for(i=1;i<result.getRowCount();i++){
				valeur+="      "+result.getElementAt(i, result.getColumnCount()-1)+"\n";
				//if(i!=result.getRowCount()-1) valeur+=",";
				 
			}
			for(j=1;j<result.getColumnCount()-1;j++){
				if(result.getValueAt(0,j)==0) continue ;
				valeur+="      "+result.getElementAt(0,j).getName()+" = 0\n";
				//valeur+=", "+result.getElementAt(0,j).getName()+" = 0\n";
			}
			valeur+="\n";
			valeur+="   Valeur Fonction Objective : "+result.getElementAt(0, result.getColumnCount()-1)+"\n";
			
			if(pivot.getRow()!=-1&& pivot.getColumn()!=-1){
				valeur+="   Ligne Pivot = "+(pivot.getRow()+1)+", Colonne Pivot = "+(pivot.getColumn()+1)+", "+pivot+"\n";
			}
			
			if(this.incomingVariable.getRow()!=-1 && this.incomingVariable.getColumn()!=-1){
				valeur+="   Variable de base Entrante : "+incomingVariable.getName()+"\n";
			}
			
			if(this.comingoutVariable.getRow()!=-1 && this.comingoutVariable.getColumn()!=-1){
				valeur+="   Variable de base Sortante : "+comingoutVariable.getName()+"\n";
			}
			
			if(this.isOptimalSolution()) valeur+="   Solution de base Optimale\n";
			else valeur+="   Solution de base non Optimale\n";
			
			if(this.isInfiniteLoop()) valeur+="   Une boucle infinie a ete detecte.\n";
			if(this.isUnlimitedFunction()) valeur+="   La Fonction Objective est une fonction illimitee.\n";
			
		}else valeur+="  [Tableau  Simplexe Resultat Vide]\n";
		return valeur+="\n";
	}
}
