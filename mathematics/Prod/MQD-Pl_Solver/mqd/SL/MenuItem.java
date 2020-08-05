
import javax.swing.*;
import javax.swing.event .*;
import java.awt.event.*;
import java.lang.String;

public class MenuItem extends JMenuItem {
		
	public MenuItem(String text) {
		super(text);
				
		if(text == "Quitter"){
			this.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				 System.exit(0);
			}} );
		}
		
		if(text == "A propos"){
			this.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				 javax.swing.JOptionPane.showMessageDialog(null,"SL Solver V 1.0 \nRealise par Gabriel Fauquembergue & Adrien Agnel \nLicence 3 UPJV Informatique\n"); 
			}} );
		}
	}

	public MenuItem(String text, Model model) {
		super(text);
				
	    if(text == "Gauss-Jordan"){
			this.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {				
				model.gaussJordan();
			}} );
		}
        
        if(text == "Exemple Matrice 2*3"){
            this.addActionListener(new ActionListener() {
                public void actionPerformed(ActionEvent e) {
                    
                    double[][] mat =  { {1,2,1},{2,3,1}};
                    double[] vecModel = {5,7};
                    
                    model.setY(2);
                    model.setX(3);
                    
                    Matrix matrix = new Matrix(model.getY(),model.getX());
                    
                    int k,w;
                    
                    for(w = 0 ;w < model.getY() ;w++){
                        for(k = 0 ;k < model.getX();k++){
                            matrix.setElementAt(w,k, new Element(w,k,mat[w][k]));
                        }
                    }
                    
                    model.setMatrix(matrix);
                    
                    Matrix vec = new Matrix(model.getY(),1);
                    
                    for(w = 0 ;w < model.getY() ;w++)
                        vec.setElementAt(w,0, new Element(w,0,(vecModel[w])));
                    
                    model.setVec(vec);

                    model.gaussJordan();
                    
                }} );
        }
	}
			
}
