
import java.util.*;
import javax.swing.*;
import java.awt.*;
import java.awt.event.*; 
import models.*;
import views.*;
import controleurs.*;
import views.MenuItem;
import java.text.*;
import java.awt.event.*;
import java.awt.print.PrinterException;

@SuppressWarnings("serial")

public class Projet extends JFrame implements Observer {
	
	private JPanel pBoutonsTab, pBoutonsHisto , pBoutonActions , pTab;
	private Box boxDonnees, boxBoutons, boxFrame ,boxPl ,boxTab;
	private JLabel contraines, variables , itLabel,itEnCourLabel;
	private ZoneIndependentVar tIndependentVar;
	private ZoneConstraints tContraintes;
	private JTextArea historique;
	private JTextField it;
	private JScrollPane sZoneHistorique,sZoneMat,sZonePl,sZoneTab;
	private Bouton generatePl,delete,start,first,result,prec,next,go,reset,threadB;
	private Model model;
	private PL pl;
	private	SimplexTab simplexTab;
	private JMenuBar menuBar;
	private JMenu fichier,algos,about,exemples,simple,factorisation,particulier;
	private MenuItem quitter,Apropos,exPc ,exDP, exD, D , simplex;
	private Dimension dZoneHisto, dBoxBoutons, dTab , dPl;

	private int selectedRow=-1,selectedColumn=-1,select=0 ;
    private SimplexeThread thread=null;
    private boolean execution = false ;

	public Projet() {
		
		super("PL solver V1.0");
		
		this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);

		model = new Model(2,3);
		
	    boxFrame = new Box(BoxLayout.Y_AXIS);
		boxDonnees = new Box(BoxLayout.X_AXIS);	
		boxBoutons = new Box(BoxLayout.X_AXIS);	
		boxPl = new Box(BoxLayout.X_AXIS);
		boxTab = new Box(BoxLayout.X_AXIS);	
	
		dBoxBoutons = new Dimension(1300,100);
		dTab = new Dimension(650,300);
		dPl = new Dimension(650,300);
		dZoneHisto = new Dimension(1300,300); 

		historique = new JTextArea();
		historique.setEditable(false);

		sZoneHistorique = new JScrollPane(historique);
		sZoneHistorique.setPreferredSize(dZoneHisto);
		sZoneHistorique.setBorder(BorderFactory.createTitledBorder(BorderFactory.createEtchedBorder(), "Historique"));		

		contraines = new JLabel("Contraites:");
		variables = new JLabel("Variables:");
		
		tContraintes = new ZoneConstraints(model);
		tIndependentVar = new ZoneIndependentVar(model);
			
		generatePl = new Bouton(model,"Generer");		
		delete = new Bouton(model,"Effacer");
		reset = new Bouton(model,"Reset");
		threadB = new Bouton(model,"Thread");
		threadB.addActionListener(new ActionListener() {
				public void actionPerformed(ActionEvent e) {
			  		 model.getSimplex().setCurrent(0);
		             simuleIteration(-1);
				}} );
		threadB.setEnabled(false);

		model.addObserver(tContraintes);
		model.addObserver(tIndependentVar);
		model.addObserver(this);
		
		pBoutonsHisto = new JPanel();
		pBoutonsHisto.setBorder(BorderFactory.createTitledBorder(BorderFactory.createEtchedBorder(), "Actions")); 
		
		pBoutonsTab = new JPanel();
		pBoutonsTab.setBorder(BorderFactory.createTitledBorder(BorderFactory.createEtchedBorder(), "Parametres du tableau PL a generer"));

		pBoutonsTab.add(variables);  	        
		pBoutonsTab.add(tIndependentVar);
		pBoutonsTab.add(contraines);	    
		pBoutonsTab.add(tContraintes);
		pBoutonsTab.add(generatePl);

		pl = new PL(model);
        sZonePl = new JScrollPane(pl);
		sZonePl.setPreferredSize(dPl);	
		sZonePl.setBorder(BorderFactory.createTitledBorder(BorderFactory.createEtchedBorder(), "PL"));		

		pBoutonActions = new JPanel();
		pBoutonActions.setBorder(BorderFactory.createTitledBorder(BorderFactory.createEtchedBorder(), "Actions Tab"));
		
		itLabel = new JLabel("itTotal: "+"-");
		first = new Bouton(model,"<--"); 
		prec = new Bouton(model,"<-"); 
		start = new Bouton(model,"Start",pl);		
		next = new Bouton(model,"->"); 
		result = new Bouton(model,"-->");
		it = new JTextField("0");
		it.setColumns(2);
		it.setHorizontalAlignment(JTextField.CENTER);
		it.addFocusListener(new ListenForFocus());
		go = new Bouton(model,"go");
		itEnCourLabel = new JLabel("it: "+"-");

		first.setEnabled(false);
		prec.setEnabled(false);
		next.setEnabled(false);
		result.setEnabled(false);
		go.setEnabled(false);

        pBoutonActions.add(itLabel);
        pBoutonActions.add(first);
        pBoutonActions.add(prec);
        pBoutonActions.add(start);
        pBoutonActions.add(next);
        pBoutonActions.add(result);
        pBoutonActions.add(it);
        pBoutonActions.add(go);
        pBoutonActions.add(itEnCourLabel);

		pBoutonsHisto.add(delete);
		pBoutonsHisto.add(reset);
		pBoutonsHisto.add(threadB);

		boxBoutons.add(pBoutonActions);
		boxBoutons.add(pBoutonsTab);
		boxBoutons.add(pBoutonsHisto); 
		boxBoutons.setMaximumSize(dBoxBoutons);

		simplexTab  = new SimplexTab(model);
		sZoneTab = new JScrollPane(simplexTab);
		sZoneTab.setBorder(BorderFactory.createTitledBorder(BorderFactory.createEtchedBorder(), "Tableau simplex"));
		sZoneTab.setPreferredSize(dTab);

        boxTab.add(sZoneTab);
        boxPl.add(sZonePl);

		boxDonnees.add(boxTab);
		boxDonnees.add(boxPl);

		boxFrame.add(boxDonnees);
		boxFrame.add(boxBoutons);
		boxFrame.add(sZoneHistorique);

		menuBar = new JMenuBar();
		
		fichier = new JMenu("Fichier");

		algos = new JMenu("Resolutions");
        
        exPc = new MenuItem("Exemple PL",model);
        
        exDP = new MenuItem("Exemple DualPrimal",model);
		
        exD = new MenuItem("Exemple Dual",model);
        
        D = new MenuItem("Dual",model);
        
        simplex = new MenuItem("Simplex",model);

        
		quitter = new MenuItem("Quitter");
		quitter.setAccelerator(KeyStroke.getKeyStroke(KeyEvent.VK_Q,InputEvent.CTRL_MASK));
						
		fichier.add(quitter);

		about = new JMenu("?");
		Apropos = new MenuItem("A propos");

        algos.add(exPc);
        algos.add(exDP);
        algos.add(exD);
        algos.addSeparator();
        algos.add(D);
        algos.add(simplex);

		about.add(Apropos);

		menuBar.add(fichier);
		menuBar.add(algos);
		menuBar.add(about);

		this.setMinimumSize(new Dimension(750,400));
        this.setJMenuBar(menuBar);
		this.getContentPane().add(boxFrame);
		this.pack();
		this.setVisible(true);
		
	}

	public void simuleIteration(int iteration){
	
		if(thread!=null){
			thread.interrupt();
			thread = null;
		}		
		thread = new SimplexeThread(iteration);
		thread.start();
	  	execution = true;
	 }
	
	public void update(Observable source, Object donnees) {
		
		tContraintes.setText(String.valueOf(model.getNumOfConstraints()) );
		tIndependentVar.setText(String.valueOf(model.getNumOfIndependentVar()) );

		if (donnees instanceof Boolean)
		{ 
          historique.setText(model.getBuffer());
		}else if(donnees instanceof Integer){

        if(execution == false){

        simplexTab.simplexTabMaj(model);
		simplexTab.getTable().repaint();

		model.getSimplex().reinit(model.getMatrix(), model.getNumOfIndependentVar() , model.getNumOfConstraints());
		model.getSimplex().execute();

		first.setEnabled(true);
		prec.setEnabled(true);
		next.setEnabled(true);
		result.setEnabled(true);
		go.setEnabled(true);
		threadB.setEnabled(true);
        }
		}else if(donnees instanceof Character){

		  itLabel.setText("itTotal: "+(model.getSimplex().getIterationCount()));
	      itEnCourLabel.setText("it: "+(model.getIt()));
		  simplexTab.simplexTabMaj(model);
	
        }else if(donnees instanceof Float){
        boxPl.removeAll();
		pl = new PL(model);
		sZonePl = new JScrollPane(pl);
		sZonePl.setPreferredSize(dPl);	
		sZonePl.setBorder(BorderFactory.createTitledBorder(BorderFactory.createEtchedBorder(), "PL"));		
        boxPl.add(sZonePl);
        boxPl.revalidate();
        repaint();
		}

	}

	class SimplexeThread extends Thread {
		
		int index,count;
		long time = 500 ;
		
		public SimplexeThread(int iteration){
		
			if(iteration==-1){
				index = 0 ;
				count = model.getSimplex().getIterationCount()-1;
			}else{
				index = iteration ;
				count = iteration;
			}				
		}
		
		public void run() {		
		    try{
				int i;
				String message = "";				
				model.getSimplex().setCurrent(index);				
				models.SimplexeIteration iteration = model.getSimplex().getCurrentIteration();
				models.Matrix matrix = iteration.getInitialMatrix();

				loadMatrix(matrix,0,matrix.getRowCount()-1,0,matrix.getColumnCount()-1);

				model.addToBuffer("\n- --- Execution de la methode du simplexe --- \n\n");

				for(i=index;i<=count;i++){

					Thread.sleep(time+300);

					simplexTab.repaintTable(iteration.getPivot().getRow(),iteration.getPivot().getColumn(),time+400);
					
					Thread.sleep(time);

					matrix = iteration.getResultMatrix();

					model.addToBuffer("\n--- Calcul des nouvelles Valeurs \n");

					loadMatrix(matrix,0,matrix.getRowCount()-1,0,matrix.getColumnCount()-1,time,iteration.getPivot().getRow());
					
					model.addToBuffer("\n"+iteration.toString());

					if(i!=count){
						model.getSimplex().nextIteration();
						iteration = model.getSimplex().getCurrentIteration();						
					}
				}
				
				if(iteration.isOptimalSolution()) message+="   Solution Optimale atteinte.\n";
				else message+="   Solution non Optimale.\n";
				
				if(iteration.isInfiniteLoop()) message+="   Boucle infinie detectee.\n";
				
				if(iteration.isUnlimitedFunction()) message+=" Fonction Objective illimitee.\n";
				
				JOptionPane.showMessageDialog(null, message, "Resume Execution",JOptionPane.INFORMATION_MESSAGE);
				execution = false;	
				}catch(InterruptedException e){
				model.addToBuffer("Execution Interrompu");
				JOptionPane.showMessageDialog(null,"\n                        Execution Interrompu                        \n\n","Information",JOptionPane.INFORMATION_MESSAGE);				
			}		
			
		}

		public void loadMatrix(models.Matrix matrix,int rowB,int rowE,int columnB,int columnE){
		
		boolean load = (matrix!=null) && rowB>=0 && rowE<matrix.getRowCount() && columnB>=0 && columnE<matrix.getColumnCount() ;
		
		if(load){
			int i,j;
			DecimalFormat nombre = new DecimalFormat("0.00");
			for(i=rowB;i<=rowE;i++){			
				for(j=columnB;j<=columnE;j++){					
					if(j!=(matrix.getColumnCount()-1)){
							simplexTab.getTable().setValueAt(""+nombre.format(matrix.getValueAt(i, j)), i, j);
					}else{
						simplexTab.getTable().setValueAt(""+matrix.getElementAt(i, j).getName(), i, j);
					}
				}
			}
		}else System.out.println("LOAD Erreur");
	   	
	   }

	   public void resetVariable(){
		   select = 0;
		   selectedRow = -1 ;
		   selectedColumn = -1;
	   }

		private void loadMatrix(models.Matrix matrix,int rowB,int rowE,int columnB,int columnE,long time,int row) throws InterruptedException{
		
		boolean load = (matrix!=null) && rowB>=0 && rowE<matrix.getRowCount() && columnB>=0 && columnE<matrix.getColumnCount() && time>=0 ;
		load = load && row >= (-1) && row < matrix.getRowCount(); 
		if(load) {
			int i,j;
			DecimalFormat nombre = new DecimalFormat("0.00");
			if(row!=-1){
				model.addToBuffer("\n--- Calcul de la ligne Pivot.\n");
				
				for(j=columnB;j<=columnE;j++){					
					
					select = 3;
					selectedRow = row ;
					selectedColumn = j;

					simplexTab.majVariable(select,selectedColumn,selectedRow);
					simplexTab.getTable().repaint(); // repaint table
					resetVariable();

					Thread.sleep(time);
					
					if(j!=(matrix.getColumnCount()-1))
						simplexTab.getTable().setValueAt(""+nombre.format(matrix.getValueAt(row, j)), row, j);
					else
						simplexTab.getTable().setValueAt(""+matrix.getElementAt(row, j).getName(), row, j);
					
					Thread.sleep(time);

					select = 0;
					selectedRow = -1 ;
					selectedColumn = -1;

				    simplexTab.majVariable(select,selectedColumn,selectedRow);
					simplexTab.getTable().repaint(); // repaint table
					resetVariable();

					Thread.sleep(time);
				}				
			}
			
			for(i=rowB;i<=rowE;i++){
				if(i==row) continue ;
				model.addToBuffer("\n--- Calcul de la nouvelle ligne "+(i+1)+".\n");
				for(j=columnB;j<=columnE;j++){
					select = 3;
					selectedRow = i ;
					selectedColumn = j;

					simplexTab.majVariable(select,selectedColumn,selectedRow);
					simplexTab.getTable().repaint(); // repaint table
					resetVariable();

					Thread.sleep(time);

					if(j!=(matrix.getColumnCount()-1))
						simplexTab.getTable().setValueAt(""+nombre.format(matrix.getValueAt(i, j)), i, j);
					else
						simplexTab.getTable().setValueAt(""+matrix.getElementAt(i, j).getName(), i, j);
					Thread.sleep(time);
					select = 0;
					selectedRow = -1 ;
					selectedColumn = -1;
					
                    simplexTab.majVariable(select,selectedColumn,selectedRow);
					simplexTab.getTable().repaint(); // repaint table
					resetVariable();

					Thread.sleep(time);
				}
			}
		}else System.out.println("PB survenu lors du chargement de la matrice.");		
	   }
	}

	public class ListenForFocus extends FocusAdapter{
		@Override
		public void focusGained(FocusEvent e) {
			Component comp = e.getComponent();
			if(comp instanceof JTextField){
				((JTextField) comp).setText("");
			}
		}

		@Override
		public void focusLost(FocusEvent e) {
			Component comp = e.getComponent();
			if(comp instanceof JTextField){
			if(((JTextField) comp).getText().equals("") ||
			   Integer.parseInt(((JTextField) comp).getText()) < 0 ||
			   Integer.parseInt(((JTextField) comp).getText()) > model.getSimplex().getIterationCount()
			  )
			  ((JTextField) comp).setText("0");
			else
				model.setItAsk(Integer.parseInt(((JTextField) comp).getText()));
			}
		}
	}

	public static void main(String[] args) {
		SwingUtilities.invokeLater( new Runnable() {
				public void run() {
					new Projet();      
				}
		});   
	}
}
