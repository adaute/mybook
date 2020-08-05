

import javax.swing.*;
import javax.swing.event .*;
import java.awt.event.*;
import java.lang.String;

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
	
	}	
	public Bouton(Model model, String text,PL pl) {
		super(text);
		this.model=model;

		if(text == "Start"){
			this.addActionListener(new ActionListener() {
				public void actionPerformed(ActionEvent e) {
						 model.generateMatrice(pl);
				}} );
		}
	}	

}
