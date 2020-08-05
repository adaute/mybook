package controller;

import java.awt.*;
import java.awt.event.*;
import javax.swing.*;

import view.VueNuage;
import model.Model;
import libs.*;

public class ControleurApprentissage extends JPanel{
  private Model model;
  private double w0, w1, w2, alpha;
  private double x1, x2, z;
  private int yt, y;
  private int t, j;
  private JButton start,stop,next,cancel;
  private JLabel droite,cptIt;
  private JTextField rate,iteration;  
  private VueNuage vueNuage;
  private Boolean trainToLearn;
  private AppThread appThread = null;

  public ControleurApprentissage() {
	this.w0 = 0;
	this.w1 = 0.1;
	this.w2 = 0.1;
	this.t = 0;
	this.j = 1;
	this.trainToLearn = false;
		
	JPanel boite = new JPanel(new GridLayout(7,2));
	
	rate = new JTextField(4);
	iteration = new JTextField(4);

    boite.add(new JLabel("Taux apprentisage"));
    boite.add(rate);
	boite.add(new JLabel("Iterations"));
    boite.add(iteration);

	boite.add(new JLabel("Pas a pas"));
	
	next = new JButton("Suivant");
	boite.add(next);
	
	boite.add(new JLabel("Automatic"));
	
	start = new JButton("Lancer");
	
    stop = new JButton("Arreter");
	stop.setEnabled(false);
	
	Box boxPBoutons = new Box(BoxLayout.X_AXIS);   
	boxPBoutons.add(start);
	boxPBoutons.add(stop);
	
	boite.add(boxPBoutons);
	
	boite.add(new JLabel("Recommencer simulation"));
	cancel = new JButton("Recommencer");
	cancel.setEnabled(false);
	boite.add(cancel);
	
	boite.add(new JLabel("Valeur de la droite :"));
	droite = new JLabel("XXXXX"); 
	boite.add(droite);

    boite.add(new JLabel("Iteration(s) restante(s) : "));
	cptIt = new JLabel("XXXXX"); 

	boite.add(cptIt);	
	
	add(boite);
	
	/*
	utilisation de focus listener qui permettent d enregistrer la valeur dans le modele sans passer par un bouton
	pour tous les JTextField
	
	verification des valeurs via les methodes contenues dans controleurtype et alerte si erreur via les methodes de controleuralerte)
	*/
	
	rate.addFocusListener(new FocusListener(){ 
		public void focusGained(FocusEvent e) {
			rate.setText("");
		}
			
       	public void focusLost(FocusEvent e) {
			if(!TestTypes.isDoubleAndGood(rate.getText())){
				if(!rate.getText().equals(""))
					Alertes.setAlertError("Rate doit etre compris entre 0 et 1\nS'ecrit avec un.\nExemple : 0.1\nValeur remise par default 0.1","Attention"); 
					rate.setText(String.valueOf(model.getRate()));
				}else
					model.setRate(Double.parseDouble(rate.getText()));
       	}
    });
		
	iteration.addFocusListener(new FocusListener(){
		public void focusGained(FocusEvent e) {
			iteration.setText("");
		}
					
       	public void focusLost(FocusEvent e) {
			
			if(!TestTypes.isIntegerAndGoodIter(iteration.getText())){
				if(!iteration.getText().equals(""))
					Alertes.setAlertError("Iteration doit etre superieur a 0 et inferieur a 3000","Attention");
					iteration.setText(String.valueOf(model.getIteration()));
				}else
					model.setIteration(Integer.parseInt(iteration.getText()));
       	}
    });
	
	/*
		 le bouton next lance la prochaine iteration de l apprentissage
		 
	*/
	next.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e){
			if( !model.getData().isEmpty() ){
				trainToLearn = true;
				next.setEnabled(false);
				start.setEnabled(false);
				stop.setEnabled(false);
				appThread = new AppThread(t, model.getIteration()-1,1);
				appThread.start();
			}
    }} );
	
	/*
		le bouton lancer lance l apprentissage de maniere automatique
	*/
	start.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e){
		 if( !model.getData().isEmpty() ){
			trainToLearn = true;
			stop.setEnabled(true);
		    start.setEnabled(false);
			cancel.setEnabled(false);
			next.setEnabled(false);
			appThread = new AppThread(t, model.getIteration()-1,model.getIteration() - t);
			appThread.start();
		 }
    }} );
	
	/*
	*/
	stop.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e){
		 appThread.interrupt();
		 trainToLearn = false;
		 stop.setEnabled(false);
		 start.setEnabled(true);
		 cancel.setEnabled(true);
    }} );
	
	/*
		le bouton arreter reinitialise les parametres
	*/
	cancel.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e){
		 atBeginning();
    }} );
	
  } 
  
  public void apprentissage() {
		if(t<model.getIteration() && j>0 ){
			j = 0;
			for (int i=0; i< model.getData().size(); i++) {
				// calculer le resultat y pour un exemple
				x1 = model.getData().get(i).getX1();
				x2 = model.getData().get(i).getX2();
				z = w0+w1*x1+w2*x2;
				y = z>0 ? 1 : 0;
				
				model.getData().get(i).setY(y);
						    	    
				yt = model.getData().get(i).getYt();
		    	// si le resultat calcule est different de celui attendu, ajuster les poids
				if (y!=yt) {
					j++;
					w0 = w0+alpha*(yt-y)*1;
					w1 = w1+alpha*(yt-y)*x1;
					w2 = w2+alpha*(yt-y)*x2;
				}
			}
		
			t++;  

			try {
				Thread.sleep(1000);
			} catch (InterruptedException e) {
				e.printStackTrace();   
			}
	
			vueNuage.addWeight(w0, w1, w2);
			vueNuage.repaint();	
		}
 }
 
 class AppThread extends Thread {
    private int iterration;
	private int tThread;
	private int stepByStep;
	private int jThread;

    public AppThread(int tThread , int iterration, int stepByStep) {
	  this.tThread = tThread;     
	  this.iterration = iterration;
	  this.stepByStep = stepByStep;
    }
    public void run() {
      try {  
		    for (int i=stepByStep; (i > 0) && ! Thread.currentThread().isInterrupted() && model.getIteration() - tThread > 0 ; i--) {
				Thread.sleep(1000);
				final int reste = i;
				if( j == 0 || Thread.currentThread().isInterrupted() ){
					break;
				}
				SwingUtilities.invokeLater( new Runnable() {
				public void run() {
					cptIt.setText(String.valueOf(iterration-tThread-(stepByStep-reste)));
					apprentissage();
					droite.setText(String.format("X2= %+5.2f*X1%+5.2f%n", w1/(-w2), w0/(-w2)));
				}});
			}	
			
	    if (stepByStep == 1) {
			 next.setEnabled(true); 
			 start.setEnabled(true);
			 cancel.setEnabled(true);
		}
	  
        if (! Thread.currentThread().isInterrupted()) {
          SwingUtilities.invokeLater( new Runnable() {
            public void run() {
              next.setEnabled(true); 
        	  stop.setEnabled(false);
			  start.setEnabled(true);
			  cancel.setEnabled(true);
          }});
        }
		
		model.getAllY();
		
      } catch (InterruptedException ie) {
      } 
    }
  }  
  
	// reinitialisation des parametres
    public void atBeginning(){
		cptIt.setText("XXXXX");
		droite.setText("XXXXX");
		this.w0 = 0;
		this.w1 = 0.1;
		this.w2 = 0.1;
		this.t = 0;
		this.j = 1;
		this.trainToLearn = false;
		this.alpha = model.getRate();
		this.vueNuage = vueNuage;
		rate.setText(String.valueOf(model.getRate()));
		iteration.setText(String.valueOf(model.getIteration()));
		vueNuage.addWeight(w0, w1, w2);
		vueNuage.resetLineArraylist();
		vueNuage.repaint();
		model.resetYAndYt();
   }
  
   public void resetAll(){
	   	model.resetData();
		cptIt.setText("XXXXX");
		droite.setText("XXXXX");
		this.w0 = 0;
		this.w1 = 0.1;
		this.w2 = 0.1;
		this.t = 0;
		this.j = 1;
		this.trainToLearn = false;
		this.alpha = model.getRate();
		this.vueNuage = vueNuage;
		rate.setText(String.valueOf(model.getRate()));
		iteration.setText(String.valueOf(model.getIteration()));
		vueNuage.addWeight(w0, w1, w2);
		vueNuage.resetLineArraylist();
   }
 	
	public void setModel(Model model,VueNuage vueNuage) {
		this.model = model;
		this.alpha = model.getRate();
		this.vueNuage = vueNuage;
		rate.setText(String.valueOf(model.getRate()));
		iteration.setText(String.valueOf(model.getIteration()));
		vueNuage.addWeight(w0, w1, w2);
		model.setCApprentissage(this);
	}

	public boolean gettrainToLearn(){
		return	this.trainToLearn;
	}

}