package view;

import java.util.*;
import java.awt.*;
import javax.swing.*;

import model.Model;

public class VueFile extends JPanel implements Observer 
{
  private Model model;
  private JLabel src;
  
  public VueFile(Model model) {
    this.model = model;
	src = new JLabel("Pas de fichier charge"); //initialisation sans fichier
    add(src); 
  }

  public void update(Observable source, Object donnees) {	
    if ((source instanceof Model) && (donnees != null)
        && (donnees instanceof String)) {
			src.setText((String)donnees); // affichage du nom de fichier
        }
  }
} 
