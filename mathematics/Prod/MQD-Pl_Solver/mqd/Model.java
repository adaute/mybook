
import java.util.Observable;
import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.event.*;
import java.util.*;
import java.util.ArrayList;


public class Model extends Observable {
	private StringBuffer sBuffer ; //buffer pour historique
	private int numOfIndependentVar;
	private int numOfConstraints;
    private Simplex simplex;

	public Model(int numOfIndependentVar, int numOfConstraints) { // cas des matrices
		this.numOfIndependentVar = numOfIndependentVar;
		this.numOfConstraints = numOfConstraints;
		this.sBuffer = new StringBuffer("");
		this.simplex = new Simplex(null,0,0);
	}

	public void genererPL(PL pl){
		pl.convertToSimplex(this);
		addToBuffer(pl.printSimplex());
		addToBuffer("\n");
		setChanged();
	    notifyObservers(new Boolean(""));
 	}

    /*** Interaction nbr contraintes et variables**/
	public int getNumOfIndependentVar(){return this.numOfIndependentVar;}
	public int getNumOfConstraints(){return this.numOfConstraints;}	

	public void setNumOfIndependentVar(int numOfIndependentVar){
		if ( numOfIndependentVar != 0){ 
			this.numOfIndependentVar=numOfIndependentVar;
			setChanged();
		}
	}
	
	public void setNumOfConstraints(int numOfConstraints){
		if (numOfConstraints != 0){ 
			this.numOfConstraints=numOfConstraints;
			setChanged();
		}
	}


	/***buffer historique **/
	public String getBuffer(){String str = sBuffer.toString(); return str;}
	
	public void setBuffer(String str){
		sBuffer = new StringBuffer(str);
	}
	
	public void addToBuffer(String str){ 
		sBuffer.append(str);
	}
	
	
	public void deleteHistorique(){
		setBuffer("");
	}
	
	/*** Actualisation GUI **/
	public void actualiserGui(){
	 setChanged();
	 notifyObservers();
	}
	
}