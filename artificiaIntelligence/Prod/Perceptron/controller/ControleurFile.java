package controller;

import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import java.io.*;
import javax.swing.filechooser.*;
import javax.swing.*;
import java.util.*;

import model.Model;
import libs.*;

public class ControleurFile extends JPanel{
  private Model model;
  private JButton load;

  public ControleurFile() {
    JPanel boite = new JPanel();
	
	boite.add(new JLabel("Ouvrir un fichier :"));

	load = new JButton("Ouvrir");
	
    load.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e){			
			runLoadFile();          
    }} );

	boite.add(load);
	add(boite);
  } 
   /*
	utilisation d'un FileChooser pour l interface de selection de fichier
   */
  public void runLoadFile(){
	JFileChooser fileChooser = new JFileChooser();
	FileNameExtensionFilter filter = new FileNameExtensionFilter("Text Files(*.txt)", "txt", "text");
	fileChooser.setFileFilter(filter);
	fileChooser.setAcceptAllFileFilterUsed(false);
	if (fileChooser.showOpenDialog(this) == JFileChooser.APPROVE_OPTION) {
		if(model.getSrc().indexOf(fileChooser.getSelectedFile().getName()) == -1)
			loadFile(fileChooser);
		else
			Alertes.setAlertError("Vous ne pouvez pas recharger le meme fichier","Attention");
	}
  }
  
    public void loadFile(JFileChooser fileChooser) {
		File selectedFile = fileChooser.getSelectedFile();
		int n;
		
		// verifie si une simulation est en cours
		if(model.getCApprentissage().gettrainToLearn()){
			n = Alertes.setYesNoAsk("Une simulation est en cours voulez vous l arreter ?","Attention");
			if( n == 0){ // oui je veux
				if(!model.getData().isEmpty()){
					n = Alertes.setYesNoAsk("Des points existent dans la liste, voulez-vous les conserver ?","Attention");
					if( n == 1){
						model.resetData();
						model.getCApprentissage().resetAll();
					}
				}
				model.setSrc(fileChooser.getSelectedFile().getPath());
				lectureFile(selectedFile);
			}

		}else{
			if(!model.getData().isEmpty()){
					n = Alertes.setYesNoAsk("Des points existent dans la liste, voulez-vous les conserver ?","Attention");
					if( n == 1){
						model.resetData();
						model.getCApprentissage().resetAll();
					}
			}
			model.setSrc(fileChooser.getSelectedFile().getPath());
			lectureFile(selectedFile);
		}           
    }
  public void lectureFile(File selectedFile){
	  	String line="";

	   try (BufferedReader br = new BufferedReader(new FileReader(selectedFile))) {
			
			line = br.readLine();
			
			while (line != null) {

				String[] lineSplit = line.split("\\s+");
				lineSplit = Arrays.stream(lineSplit).filter(s -> (s != null && s.length() > 0)).
                        toArray(String[]::new);
				
				if(lineSplit.length == 3 
					&& model.addData(
						Double.parseDouble(lineSplit[0]),
						Double.parseDouble(lineSplit[1]),
						Integer.parseInt(lineSplit[2])
						) != -1
				)		  									
					line = br.readLine();
				else{
					Alertes.setAlertError("Des informations dans le fichier sont fausses\nAnnulation de l import du fichier txt","Data insert error");
					model.resetData();
					model.setSrc("Pas de fichier charge");
					break;
				}
            }
		
        } catch (IOException e) {
            e.printStackTrace();
        }
  }
  public void setModel(Model model) {
  	this.model = model;
  }
}