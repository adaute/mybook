/*
  * Created on 12 may. 2018
 *
 * TODO To change the template for this generated file go to
 * Window - Preferences - Java - Code Style - Code Templates
 */
package logogui;

import javafx.scene.canvas.GraphicsContext;
import javafx.scene.paint.Color;

import java.util.ArrayList;

import org.antlr.v4.runtime.misc.Triple;

public class Traceur {
	
	private Color couleur;
	private Boolean trace = true;
	private double thickness = 1.0;
	private double initx = 400, inity = 300; // position initiale
	private double posx = initx, posy = inity; // position courante
	
	private double angle = 90;
	private double teta;
	
	private ArrayList<Triple<Double, Double, Double>> storedData = new ArrayList<Triple<Double, Double, Double>>();
	
	GraphicsContext gc;
	LogoGraphContext logoGraphContext = LogoGraphContext.getInstance();

	public Traceur() {
		setTeta();
		couleur = Color.BLACK;
	}

	public void setGraphics(GraphicsContext gc) {
		this.gc = gc;
		gc.setLineWidth(thickness);
	}

	private void setTeta() {
		teta = Math.toRadians(angle);
	}

	private void addLine(double x1, double y1, double x2, double y2) {
		logoGraphContext.addLine(x1, y1, x2, y2, couleur);

	}

	public void avance(double r) {
		double a = posx + r * Math.cos(teta);
		double b = posy - r * Math.sin(teta);
		if (this.trace)
			addLine(posx, posy, a, b);
		posx = a;
		posy = b;
	}

	public void recule(double r) {
		avance(-r);
	}
	
	public void td(double r) {
		angle = (angle - r) % 360;
		setTeta();
	}

	public void tg(double r) {
		angle = (angle + r) % 360;
		setTeta();
	}

	public void lc() {
		this.trace = false;
	}
	
	public void bc() {
		this.trace = true;
	}
	
	public void ft(double r) {
		thickness = r;
		// gc.setLineWidth(thickness);
	}

	public void ve() {
		logoGraphContext.stop();
		gc.clearRect(0, 0, gc.getCanvas().getWidth(), gc.getCanvas().getHeight());
	}
	
	public void fpos(double a, double b){
		this.posx = a;
		this.posy = b;
	}
	
	public void fcc(double r, double g, double b) {
		try{
			Color co = new Color(r/255, g/255,b/255, 1);
			this.couleur = co;  
		}catch(Exception e){e.printStackTrace();}
	}
	
	public void store() {
		Triple<Double, Double, Double> triple = new Triple<Double, Double, Double>(this.posx,  this.posy, this.angle); 
		this.storedData.add(triple);
	}
	
	public void move() {
		this.posx = this.storedData.get(this.storedData.size()-1).a;
		this.posy = this.storedData.get(this.storedData.size()-1).b;
		this.angle = this.storedData.get(this.storedData.size()-1).c;
		setTeta();
		this.storedData.remove(this.storedData.size()-1);
	}
}
