
import java.util.*;
import javax.swing.*;
import java.awt.*;
import java.awt.event.*; 
import java.text.*;
import java.awt.event.*;

@SuppressWarnings("serial")

public class ProjetSL extends JFrame implements Observer {
	
	private JPanel pBoutonsTab, pBoutonsHisto , pBoutonActions;
	private Box boxDonnees, boxBoutons, boxFrame , boxSl;
	private JLabel lignes, colonnes , itLabel,itEnCourLabel;
	private ZoneLignes tLignes;
	private ZoneColonnes tColonnes;
	private JTextArea historique;
	private JScrollPane sZoneHistorique,sZoneMat,sZoneSl;
	private Bouton delete,generate,start;
	private Model model;
	private JMenuBar menuBar;
	private JMenu fichier,algos,about,exemples,simple,factorisation,particulier;
    private MenuItem quitter,Apropos,gaussJ,Ex23GausJordan;
	private Dimension dZoneHisto, dBoxBoutons,dSl;
	private PL pl;
    
	public ProjetSL() {
		
		super("SL solver V1.0");
		
		this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);

		model = new Model(3,2);
		
	    boxFrame = new Box(BoxLayout.Y_AXIS);
		boxDonnees = new Box(BoxLayout.X_AXIS);	
		boxBoutons = new Box(BoxLayout.X_AXIS);	
		boxSl = new Box(BoxLayout.X_AXIS);
	
		dZoneHisto = new Dimension(400,300);
		dSl = new Dimension(400,300);
		dBoxBoutons = new Dimension(800,100); 

		historique = new JTextArea();
		historique.setEditable(false);

		sZoneHistorique = new JScrollPane(historique);
		sZoneHistorique.setPreferredSize(dZoneHisto);
		sZoneHistorique.setBorder(BorderFactory.createTitledBorder(BorderFactory.createEtchedBorder(), "Historique"));		
        
        pl = new PL(model);
        sZoneSl = new JScrollPane(pl);
        sZoneSl.setPreferredSize(dSl);
		sZoneSl.setBorder(BorderFactory.createTitledBorder(BorderFactory.createEtchedBorder(), "SL"));		
        
        boxSl.add(sZoneSl);

        boxDonnees.add(boxSl);
        boxDonnees.add(sZoneHistorique);

		lignes = new JLabel("Lignes:");
		colonnes = new JLabel("Colonnes:");

		tColonnes = new ZoneColonnes(model);
		tLignes = new ZoneLignes(model);
			
		start = new Bouton(model,"Start",pl);
		delete = new Bouton(model,"Effacer");
		generate = new Bouton(model,"Generer");

		model.addObserver(tColonnes);
		model.addObserver(tLignes);
		model.addObserver(this);
		
		pBoutonsHisto = new JPanel();
		pBoutonsHisto.setBorder(BorderFactory.createTitledBorder(BorderFactory.createEtchedBorder(), "Actions")); 
		pBoutonsHisto.add(start);
		pBoutonsHisto.add(delete);

		pBoutonsTab = new JPanel();
		pBoutonsTab.setBorder(BorderFactory.createTitledBorder(BorderFactory.createEtchedBorder(), "Parametres SL generer"));

		pBoutonsTab.add(colonnes);  	        
		pBoutonsTab.add(tLignes);
		pBoutonsTab.add(lignes);	    
		pBoutonsTab.add(tColonnes);
		pBoutonsTab.add(generate);

		boxBoutons.add(pBoutonsTab);
		boxBoutons.add(pBoutonsHisto); 
		boxBoutons.setMaximumSize(dBoxBoutons);

		boxFrame.add(boxDonnees);
		boxFrame.add(boxBoutons);

		menuBar = new JMenuBar();
		
		fichier = new JMenu("Fichier");

		algos = new JMenu("Resolutions");
		
		quitter = new MenuItem("Quitter");
		quitter.setAccelerator(KeyStroke.getKeyStroke(KeyEvent.VK_Q,InputEvent.CTRL_MASK));
						
		fichier.add(quitter);

		about = new JMenu("?");
		Apropos = new MenuItem("A propos");

		about.add(Apropos);

        Ex23GausJordan  = new MenuItem("Exemple Matrice 2*3",model);
		gaussJ = new MenuItem("Gauss-Jordan",model);
		algos.add(gaussJ);
        algos.add(Ex23GausJordan);

		menuBar.add(fichier);
		menuBar.add(algos);
		menuBar.add(about);

		this.setMinimumSize(new Dimension(750,400));
        this.setJMenuBar(menuBar);
		this.getContentPane().add(boxFrame);
		this.pack();
		this.setVisible(true);
		
	}

	public void update(Observable source, Object donnees) {

		if (donnees instanceof Boolean)
          historique.setText(model.getBuffer());

		tLignes.setText(String.valueOf(model.getX()) );
		tColonnes.setText(String.valueOf(model.getY()) );

        boxSl.removeAll();
		pl = new PL(model);
		sZoneSl = new JScrollPane(pl);
		sZoneSl.setPreferredSize(dSl);	
		sZoneSl.setBorder(BorderFactory.createTitledBorder(BorderFactory.createEtchedBorder(), "SL"));		
        boxSl.add(sZoneSl);
        boxSl.revalidate();
        repaint();
	}

	

	public static void main(String[] args) {
		SwingUtilities.invokeLater( new Runnable() {
				public void run() {
					new ProjetSL();      
				}
		});   
	}
}
