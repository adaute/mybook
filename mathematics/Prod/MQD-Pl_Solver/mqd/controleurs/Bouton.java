package controleurs;

import javax.swing.*;
import javax.swing.event .*;
import java.awt.event.*;
import java.lang.String;
import models.Model;
import views.PL;


public class Bouton extends JButton {

	private Model model;
	
	public Bouton(Model model, String text) {
		super(text);
		this.model=model;
		
		if(text == "Generer"){
			this.addActionListener(new ActionListener() {
				public void actionPerformed(ActionEvent e) {
					 model.actualiserGui();
				}} );
		}
		
		if(text == "Effacer"){
			this.addActionListener(new ActionListener() {
				public void actionPerformed(ActionEvent e) {
					model.deleteHistorique();
				}} );
		}
		if(text == "<--"){
			this.addActionListener(new ActionListener() {
				public void actionPerformed(ActionEvent e) {
					 model.addToBuffer(model.getSimplex().firstIteration().toString());
					 model.setIt(0);
					 model.setMatrix(model.getSimplex().getCurrentIteration().getResultMatrix());
				}} );
		}

        if(text == "<-"){
			this.addActionListener(new ActionListener() {
				public void actionPerformed(ActionEvent e) {
					if( !(model.getIt()-1 < 0 || model.getIt() ==  0 || model.getIt() == 1) ) {
					 model.setIt(model.getIt()-1);
					 model.addToBuffer(model.getSimplex().previousIt().toString());
					 model.setMatrix(model.getSimplex().getCurrentIteration().getResultMatrix());
					 }else{	
					   if(model.getIt() == 1){
					     model.getSimplex().setCurrent(0);
					   	 model.setIt(model.getIt()-1);	
					   	 model.setMatrix(model.getSimplex().getCurrentIteration().getResultMatrix());
					   }			   
					  JOptionPane.showMessageDialog(null, "Premiere it (0)", "Resume Execution",JOptionPane.INFORMATION_MESSAGE);
				    }				
				}} );
		}
		if(text == "->"){
			this.addActionListener(new ActionListener() {
				public void actionPerformed(ActionEvent e) {
					if( !(model.getIt()+1 > model.getSimplex().getIterationCount()) ) {
						 model.setIt(model.getIt()+1);
						 model.addToBuffer(model.getSimplex().nextIt().toString());
					     model.setMatrix(model.getSimplex().getCurrentIteration().getResultMatrix());
					 }else
					    JOptionPane.showMessageDialog(null, "Derniere it atteinte", "Resume Execution",JOptionPane.INFORMATION_MESSAGE);
				}} );
		}
		if(text == "-->"){
			this.addActionListener(new ActionListener() {
				public void actionPerformed(ActionEvent e) {
					 model.addToBuffer(model.getSimplex().lastIteration().toString());
					 model.setIt(model.getSimplex().getIterationCount());
					 model.setMatrix(model.getSimplex().getCurrentIteration().getResultMatrix());
				}} );
		}

		if(text == "go"){
			this.addActionListener(new ActionListener() {
				public void actionPerformed(ActionEvent e) {
					 if(model.getItAsk() >= 0 && model.getItAsk() <= model.getSimplex().getIterationCount() ){ 

					 	if(model.getItAsk() == 0)
                           model.getSimplex().setCurrent(model.getItAsk());
                        else
                           model.getSimplex().setCurrent(model.getItAsk()-1);

                        model.addToBuffer(model.getSimplex().getCurrentIteration().toString());
					    model.setIt(model.getItAsk());
					    model.setMatrix(model.getSimplex().getCurrentIteration().getResultMatrix());
				   }
				}} );
		}

		if(text == "Reset"){
			this.addActionListener(new ActionListener() {
				public void actionPerformed(ActionEvent e) {
					 model.reset();
				}} );
		}
	}	

	public Bouton(Model model, String text, PL pl) {
		super(text);
		this.model=model;
		
		if(text == "Start"){
			this.addActionListener(new ActionListener() {
				public void actionPerformed(ActionEvent e) {
					model.genererPL(pl);
					model.remplirMatrix(pl);
					model.getSimplex().setCurrent(-1);
					model.actualiseIt();
				}} );
		}
	}		
	
}