package controller;

import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import java.util.*;

import model.Model;
import libs.*;

public class ControleurPoints extends JPanel{
  private Model model;
  private JTextField x1,x2,yt;
  private JButton add,delete;

  public ControleurPoints() {
    JPanel boite = new JPanel(new GridLayout(4,2));
	
    x1 = new JTextField(2);
	x2 = new JTextField(2);
    yt = new JTextField(2);

    boite.add(new JLabel("X1 :"));
    boite.add(x1);
	boite.add(new JLabel("X2 :"));
    boite.add(x2);
	boite.add(new JLabel("Yt :"));
    boite.add(yt);

	add = new JButton("Ajouter");
	
    delete = new JButton("Supprimer");
	
	Box boxPBoutons = new Box(BoxLayout.X_AXIS);   
	boxPBoutons.add(add);
	boxPBoutons.add(delete);
	
	boite.add(new JLabel("Actions :"));
	boite.add(boxPBoutons);
	
	add(boite);
	
	/*
	utilisation de focus listener qui permettent de verifier la valeur pour tous les JTextField avant ajout dans le modele
	*/
	
	x1.addFocusListener(new FocusListener(){
		public void focusGained(FocusEvent e) {
			x1.setText("");
		}
			
       	public void focusLost(FocusEvent e) {
			if(!TestTypes.isDoubleAndGood(x1.getText() ) && !x1.getText().equals("")){
				x1.setText("");
				Alertes.setAlertError("X1 est compris entre 0 et 1\nS'ecrit avec un . \nExemple 0.2","Attention");
			}
		}
    });
		
	x2.addFocusListener(new FocusListener(){
		public void focusGained(FocusEvent e) {
			x2.setText("");
		}
			
       	public void focusLost(FocusEvent e) {
			if(!TestTypes.isDoubleAndGood(x2.getText()) && !x2.getText().equals("")){
				x2.setText("");
				Alertes.setAlertError("X2 est compris entre 0 et 1\nS'ecrit avec un . \nExemple 0.2","Attention");
			}
		}
    });
		
	yt.addFocusListener(new FocusListener(){
		public void focusGained(FocusEvent e) {
			yt.setText("");
		}
			
       	public void focusLost(FocusEvent e) {
			if(!TestTypes.isIntegerAndGood(yt.getText()) && !yt.getText().equals("")){
				yt.setText("");
				Alertes.setAlertError("Y vaut 0 ou 1","Attention");
			}	   
		}
    });
	
	// ajout des points avec la methode addData du modele : si retour incorrect, message d erreur
    add.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e){
			
		int flag =  model.addData(
		    Double.parseDouble(x1.getText()),
		    Double.parseDouble(x2.getText()),
		    Integer.parseInt(yt.getText())
		  );
		  
		 if( !x1.getText().equals("") 
			 && !x2.getText().equals("") 
		 && !yt.getText().equals("") 
		 && flag != -1
		 ){	    
		  	x1.setText("");
			x2.setText("");
			yt.setText("");
			if(flag == 0)
				Alertes.setAlertError("Points deja present dans la liste","Attention");			 
		 }else
			Alertes.setAlertError("Veuillez remplir tous les champs X1,X2,Y \nX1 est compris entre 0 et 1 : s'ecrit avec un : exemple 0.2 \nX2 est compris entre 0 et 1 : s'ecrit avec un : exemple 0.2 \nY vaut 0 ou 1 \n ","Attention");			 
    }} );
	
	// suppression des points avec la methode du modele
	delete.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e){
			 if( !x1.getText().equals("") && !x2.getText().equals("") && !yt.getText().equals("") ){
				 model.deleteData(
				 Double.parseDouble(x1.getText()),
				 Double.parseDouble(x2.getText()),
				 Integer.parseInt(yt.getText())
				);
				x1.setText("");
				x2.setText("");
				yt.setText("");
				
			}else
				Alertes.setAlertError("Veuillez remplir tous les champs X1,X2,Y \nX1 est compris entre 0 et 1 : s'ecrit avec un : exemple 0.2 \nX2 est compris entre 0 et 1 : s'ecrit avec un : exemple 0.2 \nY vaut 0 ou 1 \n ","Attention");			 
    }} );
	
  } 
  
  public void setModel(Model model) {
  	this.model = model;	
  }
}