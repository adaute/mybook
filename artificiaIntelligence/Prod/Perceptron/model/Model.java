package model;

import java.util.Observable;
import java.util.*;
import javax.swing.*;

import libs.*;
import controller.ControleurApprentissage;

public class Model extends Observable{
	
	private String src;
	private double rate;
	private int iteration;
	private ControleurApprentissage controleurA;
	private ArrayList<Points> data; 

	public Model(double rate, int iteration){
		super();
		this.src = "Pas de fichier charge";
		this.rate = rate;
		this.iteration = iteration;
		this.data = new ArrayList<Points>();
	}
	
	public String getSrc() {
		return src;
	}
	 
	public void setSrc(String src) {
		if(!src.equals("Pas de fichier charge"))
			System.out.println("New src:"+src);
		else
			System.out.println("Annulation du chargement du fichier");
		if(this.src != src){
			this.src = src;
			this.setChanged();
			this.notifyObservers(src);
		}	
	}
	
	public double getRate() {
		return this.rate;
	}
	 
	public void setRate(double rate) {
		if(this.rate != rate){
			this.rate = rate;
			System.out.println("New rate:"+rate);
		}
	}
	
	public int getIteration() {
		return this.iteration;
	}
	 
	public void setIteration(int iteration) {
		if(this.iteration != iteration){
			this.iteration = iteration;
			System.out.println("New itt:"+iteration);
		}
	}
	
// fonction pour la gestion du controleur apprentissage
	public ControleurApprentissage getCApprentissage() {
		return controleurA;
	}
	 
	public void setCApprentissage(ControleurApprentissage controleurA) {
		if(this.controleurA != controleurA){
			this.controleurA = controleurA;
		}
	}

// fonction pour la gestion de la liste des valeurs test pour le perceptron
	
	public ArrayList<Points> getData() {
		return this.data;
	}
	
	public void resetData(){
		this.data.clear();
		this.setChanged();
		this.notifyObservers(true);
	}
		
	public void getAllY() {
		this.setChanged();
		this.notifyObservers(true);
	}
	
	public void resetYAndYt() {
		for(int i=0; i < data.size(); i++) {
			data.get(i).setY(data.get(i).getYt());
		}
		this.setChanged();
		this.notifyObservers(true);
	}

	public int isContainData(Points newPoint) {
		int flag = -1;
		for(int i=0; i < data.size(); i++) {
			if(data.get(i).getX1() ==  newPoint.getX1()
				&& data.get(i).getX2() ==  newPoint.getX2()
				&& data.get(i).getYt() ==  newPoint.getYt()
			)
				flag = i;
		}
		return flag;
	}
	
	/*
	verification des valeurs avant ajout : retourne un code different selon l erreur (point deja present ou valeurs erronees)
	*/
	public int addData(double x1, double x2, int yt) {
		if( (x1 > 0.0 && x1 < 1.0)  && 
		    (x2 > 0.0 && x2 < 1.0)  && 
		    (yt == 0  || yt == 1) ){
			Points newPoint = new Points(x1,x2,yt);
			
			if(isContainData(newPoint) == -1){
				data.add(newPoint);
				System.out.println("point add:"+"x1:"+x1+" X2:"+x2+" Yt:"+yt);
				this.setChanged();
				this.notifyObservers(true);
				return 1;
			}
			return 0;
		}else
			return -1;
	}
	
	public void deleteData(double x1, double x2, int yt) {
			if( (x1 > 0.0 && x1 < 1.0)  && 
		    (x2 > 0.0 && x2 < 1.0)  && 
		    (yt == 0  || yt == 1) ){
			Points newPoint = new Points(x1,x2,yt);
			
			if(isContainData(newPoint) != -1){
				data.remove(isContainData(newPoint));
				System.out.println("point delete:"+"x1:"+x1+" X2:"+x2+" Yt:"+yt);
				this.setChanged();
				this.notifyObservers(true);
			}
		}
	}
	
	public int isContainLine(Lines newLines,ArrayList<Lines> lines) {
		int flag = -1;
		for(int i=0; i < lines.size(); i++) {
			if(lines.get(i).getX1() ==  newLines.getX1()
				&& lines.get(i).getY1() ==  newLines.getY1()
				&& lines.get(i).getX2() ==  newLines.getX2()
				&& lines.get(i).getY2() ==  newLines.getY2()
			)
				flag = i;
		}
		return flag;
	}	
// .....

}
