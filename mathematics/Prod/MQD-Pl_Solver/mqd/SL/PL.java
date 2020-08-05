
import java.util.*;
import javax.swing.*;
import javax.swing.event .*;
import java.awt.*;
import java.awt.event.*;
import java.awt.Component;

@SuppressWarnings("rawtypes")

public class PL extends JPanel{
	private static final int textFieldSize=3;
	public int x;
    public int y;
    public Model model;

	private String varName="x";
	
	ArrayList<JLabel> labels;

	private GridBagConstraints gridBag;

	static JTextField inputConstraintVec[];
	static JTextField inputConstraintMatrix[][];
	
	public PL(Model model) {

		this.model = model;

        x = model.getX();
        y = model.getY();

		setLayout(new GridBagLayout());
				
		gridBag = new GridBagConstraints();
		
		gridBag.gridx=1;
		gridBag.gridy=1;
		gridBag.gridwidth=1;
		gridBag.gridheight=1;
		gridBag.weightx=50;
		gridBag.weighty=10;
		gridBag.insets= new Insets(5,5,5,5);
		gridBag.anchor = GridBagConstraints.CENTER;
		gridBag.fill = GridBagConstraints.HORIZONTAL;

		labels = new ArrayList<JLabel>();

		// les colonnes
		inputConstraintVec = new JTextField[y];

		for(int i=0;i<inputConstraintVec.length;i++){
			inputConstraintVec[i]= new JTextField("0");
			inputConstraintVec[i].setColumns(textFieldSize);
			inputConstraintVec[i].setHorizontalAlignment(JTextField.CENTER);
			inputConstraintVec[i].addFocusListener(new ListenForFocus());
		}

		inputConstraintMatrix =  new JTextField[y][x];
		for(int i=0;i<y;i++){
			for(int j=0;j<x;j++){
				inputConstraintMatrix[i][j] = new JTextField("0");
				inputConstraintMatrix[i][j].setColumns(textFieldSize);
				inputConstraintMatrix[i][j].setHorizontalAlignment(JTextField.CENTER);
				inputConstraintMatrix[i][j].addFocusListener(new ListenForFocus());
			}
		}

		gridBag.gridx=1;
		gridBag.gridy+=1;
		gridBag.gridwidth=20;
		gridBag.gridwidth=1;
		for(int i=0;i<inputConstraintVec.length;i++){
			gridBag.gridx=1;
			gridBag.gridy+=1;
			for(int j=0;j<x;j++){
				add(inputConstraintMatrix[i][j],gridBag);
				gridBag.gridx+=1;
				if(j!=x-1){
					labels.add(new JLabel(varName + String.valueOf(j+1)+ " +"));
				} else {
					labels.add(new JLabel(varName + String.valueOf(j+1)));
				}
				add(labels.get(labels.size()-1),gridBag);
				gridBag.gridx+=1;
			}
			add(inputConstraintVec[i],gridBag);
		}

					
    }

    public void matrixConstructor(Model model){

		int row = model.getY();
		int columm = model.getX();
        

		Matrix matrix = new Matrix(row,columm);
			
		int k,w;
        
		 for(w = 0 ;w < row ;w++){
      	    for(k = 0 ;k < columm;k++){
                 matrix.setElementAt(w,k, new Element(w,k,Double.parseDouble(inputConstraintMatrix[w][k].getText())));
                }
		  }
        

		  model.setMatrix(matrix);

		Matrix vec = new Matrix(row,1);
			       
	     for(w = 0 ;w < row ;w++)
            vec.setElementAt(w,0, new Element(w,0,Double.parseDouble(inputConstraintVec[w].getText())));

		  model.setVec(vec);

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
			if(comp instanceof JTextField && ((JTextField) comp).getText().equals("")){
					((JTextField) comp).setText("0");
			}
		}
	}

}
