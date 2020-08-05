package models;

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
	private Matrix matrice;
	private Simplex simplex;
	private int it;
	private int itAsk;

	public Model(int numOfIndependentVar, int numOfConstraints) { // cas des matrices
		this.numOfIndependentVar = numOfIndependentVar;
		this.numOfConstraints = numOfConstraints;
		this.sBuffer = new StringBuffer("");
		this.matrice = new Matrix();
		this.simplex = new models.Simplex(null,0,0);
		this.it = 0;
		this.itAsk = 0;
	}

	public void genererPL(views.PL pl){
		pl.convertToSimplex(this);
 	}
 	
 	public void remplirMatrix(views.PL pl){
        setMatrix(pl.matrixConstructor(this));	
 		setChanged();
 		notifyObservers(new Integer(0));
 	}

 	public int getItAsk(){return this.itAsk;}
	public void setItAsk(int it){
		this.itAsk = it;
	}

 	public int getIt(){return this.it;}
	public void setIt(int it){
		this.it = it;
	}

    /*** Simplex action **/
 	public void setSimplex(Simplex simplex){
			this.simplex=simplex;
			setChanged();
	}

	public Simplex getSimplex(){return this.simplex;}

 	/*** Interaction matrix **/
 	public void setMatrix(Matrix matrix){
			this.matrice=matrix;
			actualiseIt();
	}

	public Matrix getMatrix(){return this.matrice;}

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
		setChanged();
	    notifyObservers(new Boolean(""));
	}
	
	
	public void deleteHistorique(){
		setBuffer("");
		setChanged();
	    notifyObservers(new Boolean(""));
	}
	
	/*** Actualisation GUI **/
	public void actualiserGui(){
	 setChanged();
	 notifyObservers(new Float(0.0));
	}

	public void actualiseIt(){
		setChanged();
	    notifyObservers(new Character((char) 1));
	}

	public void reset(){
		this.simplex = new models.Simplex(null,0,0);
		setChanged();
		notifyObservers(new Boolean(""));
	}
	
}
