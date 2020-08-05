import java.awt.*;
import javax.swing.*;
import model.Model;

import controller.*;
import view.*;
import libs.*;

public class ProjetGUI extends JFrame {
	public ProjetGUI() {
		super("MVC V4.0");
		this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		
		Model model = new Model(0.1, 200);
		
    	VueFile vueF = new VueFile(model);
		VueTab vueT = new VueTab(model);
		VueNuage vueG = new VueNuage(model);
		
        ControleurPoints controlGra = new ControleurPoints();
		ControleurApprentissage controla = new ControleurApprentissage();
		ControleurFile controlf = new ControleurFile();
				
        controlGra.setModel(model);
		controlf.setModel(model);
		controla.setModel(model,vueG);
		
        model.addObserver(vueF);
    	model.addObserver(vueT);
    	model.addObserver(vueG);
		
        JPanel panel = new JPanel();
		
		Dimension sizeTab = new Dimension(700,700);
		
		JTabbedPane onglets = new JTabbedPane(SwingConstants.TOP);
		
		JPanel Ongletconfig = new JPanel(new GridLayout(3,1));
		Ongletconfig.setPreferredSize(sizeTab);
		Ongletconfig.add(controla);
		onglets.addTab("Configuration", Ongletconfig);
		
		JPanel OngletPoints= new JPanel(new GridLayout(2,1));
		OngletPoints.setPreferredSize(sizeTab);
		OngletPoints.add(controlGra);
		OngletPoints.add(new JScrollPane(vueT));
		onglets.addTab("Gestions Points", OngletPoints);
		
		JPanel OngletFile= new JPanel();
		OngletFile.setPreferredSize(sizeTab);
		OngletFile.add(controlf);
		OngletFile.add(vueF);
		onglets.addTab("Charger un Fichier", OngletFile);
					
		JPanel OngletCopyright= new JPanel();
		OngletCopyright.setPreferredSize(sizeTab);
		OngletCopyright.add(new JLabel("Realise par Adrien Agnel \n Licence 3 UPJV Informatique 2017"));
		onglets.addTab("Copyright", OngletCopyright);
		
		onglets.setOpaque(true);
		
		JTabbedPane ongletsDt = new JTabbedPane(SwingConstants.TOP);

		JPanel OngletGraphique = new JPanel();
		OngletGraphique.setPreferredSize(sizeTab);
		OngletGraphique.add(vueG);
		ongletsDt.addTab("Graphique", OngletGraphique);
				
		panel.add(onglets);
    	panel.add(ongletsDt);

		this.setResizable(false);
    	this.setContentPane(panel);
    	this.pack();
    	this.setVisible(true);    
	}		
	    
	public static void main(String[] args) throws Exception {
        javax.swing.SwingUtilities.invokeLater(new Runnable() {
			public void run() { 
				new ProjetGUI();
			} 
        });
    }
    
}


