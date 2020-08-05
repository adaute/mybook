
import java.util.Observable;
import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.event.*;
import java.util.*;
import java.util.ArrayList;

public class Model extends Observable {
	private StringBuffer sBuffer ; //buffer pour historique
	private int x;
	private int y;
	private Matrix matrice;
	private Matrix vec;

	public Model(int x, int y) { // cas des matrices
		this.x = x;
		this.y = y;
		this.sBuffer = new StringBuffer("");
		this.matrice = new Matrix();
		this.vec = new Matrix();
	}

	/*** Gestion des Matrix **/

	public void setMatrix(Matrix matrix){
			this.matrice=matrix;
	}

	public Matrix getMatrix(){return this.matrice;}

	public void setVec(Matrix matrix){
			this.vec=matrix;
	}

	public Matrix getVec(){return this.vec;}

    /*** Interaction nbr contraintes et variables**/
	public int getX(){return this.x;}
	public int getY(){return this.y;}	

	public void setX(int x){
		if ( x != 0){ 
			this.x=x;
			setChanged();
		}
	}
	
	public void setY(int y){
		if (y != 0){ 
			this.y=y;
			setChanged();
		}
	}

	public void generateMatrice(PL pl){
	  pl.matrixConstructor(this);
	}

	/***  Algos   **/
	public void gaussJordan(){
	  GaussJordan simpleGJ = new GaussJordan(this,matrice,vec);
      simpleGJ.GaussJordan();
      actualiserGui();

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
		setChanged();
	    notifyObservers(new Boolean(""));
	}

	public void actualiserGui(){
		setChanged();
	    notifyObservers(new Boolean(""));
	}
	
	
}
