package view;

import java.util.*;
import java.awt.*;
import javax.swing.*;
import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.event.*;

import model.Model;
import libs.*;

public class VueNuage extends JPanel implements Observer 
{
  private Model model;
  private double w0, w1, w2;
  private ArrayList<Lines> lines; 
  
  public VueNuage(Model model) {
    this.model = model;
	this.lines = new ArrayList<Lines>();
	setPreferredSize(new Dimension(700,700));
	setBackground(Color.WHITE);
  }
  
  public void addWeight(double w0, double w1, double w2) {
    this.w0 = w0;
    this.w1 = w1;
    this.w2 = w2;
  }
  
  public void paintComponent(Graphics g) {
	super.paintComponent(g);
    int w = getWidth();  
    int h = getHeight();
	
	Graphics2D g2d = (Graphics2D) g;
	
	// dessiner les droites du graphique
	g2d.setColor(Color.black);
	g2d.drawLine(0, h/2, h, h/2);
	g2d.drawLine(h/2, 0, h/2, h);
    
	if( !model.getData().isEmpty()){
	// dessiner les exemples
	for (int i=0; i<model.getData().size(); i++) {
		if (model.getData().get(i).getYt()==1) {
		    g2d.setColor(Color.red);
		    g2d.drawString("+",
			(h/2)+(int)((model.getData().get(i).getX1())*1000),
			(h/2)-(int)(model.getData().get(i).getX2()*1000)
			);
		} else {
		    g2d.setColor(Color.blue);
		    g2d.drawString("+",
			(h/2)+(int)((model.getData().get(i).getX1())*1000),
			(h/2)-(int)(model.getData().get(i).getX2()*1000));
		}
	}
				
	// dessiner la ligne (w0+w1*x1+w2*x2=0) qui separe les exemples a partir de deux points (x1, y1) et (x2, y2)
	double x1, y1, x2, y2;
	    
	x1=0.0; y1=(-w0-w1*x1)/w2;	
	y2=0.0; x2=(-w0-w2*y2)/w1; 	
	
	for (int j=0; j<lines.size(); j++) {
		g2d.setStroke(new BasicStroke(0.005f));
	    g2d.setColor(Color.magenta);
		g2d.drawLine(lines.get(j).getX1(), lines.get(j).getY1(), lines.get(j).getX2(), lines.get(j).getY2());
	}
	
	g2d.setStroke(new BasicStroke(2.0f));
	g2d.setColor(Color.green);
	g2d.drawLine((h/2)+(int)(x1*1000), (h/2)-(int)(y1*1000), (h/2)+(int)(x2*1000), (h/2)-(int)(y2*1000));
	
	Lines newLines = new Lines((h/2)+(int)(x1*1000),(h/2)-(int)(y1*1000), (h/2)+(int)(x2*1000), (h/2)-(int)(y2*1000));

	if(model.isContainLine(newLines,lines)  == -1)
		lines.add(newLines);	
	
  	}
 }
  public void resetLineArraylist() {
    lines.clear();
  }
	
  public void update(Observable source, Object donnees) {	
    if ((source instanceof Model) && (donnees != null)
		&& (donnees instanceof Boolean)) {
			repaint();
	}
  }
  
  
} 
