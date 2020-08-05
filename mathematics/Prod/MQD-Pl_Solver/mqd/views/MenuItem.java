package views;

import javax.swing.*;
import javax.swing.event .*;
import java.awt.event.*;
import java.lang.String;

import models.Model;
import models.SimplexBland;
import models.SimplexProblem;
import models.SimplexSolver;
import models.Matrix;

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
				 javax.swing.JOptionPane.showMessageDialog(null,"PL Solver V 1.0 \nRealise par Gabriel Fauquembergue & Adrien Agnel \nLicence 3 UPJV Informatique\n"); 
			}} );
		}
		
	}
			
	public MenuItem(String text,Model model) {
		super(text);
        
        if(text == "Exemple PL"){
            this.addActionListener(new ActionListener() {
                public void actionPerformed(ActionEvent e) {
                    
                    double[][] A = {
                        { 2 , 1 },
                        { 1 , 2 },
                        { 0 , 1 },
                    };
                    double[] c = { 4,5};
                    double[] b = { 8,7,3};
                    
                    SimplexBland lp = new SimplexBland(A, b, c, model);
                    model.addToBuffer("Solution final\n\n");

                    model.addToBuffer("Z = " + lp.value()+"\n\n");
                    
                    lp.solution();
                    
                    
                }} );
            
        }
        
        if(text == "Exemple DualPrimal"){
            this.addActionListener(new ActionListener() {
                public void actionPerformed(ActionEvent e) {
                    
                    String contents = "2;3;;\nmax;4;5;0\n true; true;;\n<=;2.0;1.0;8.0\n<=;1.0;2.0;7.0\n<=;0.0;1.0;3.0";
                    
                    //create new problem
                    SimplexProblem p = new SimplexProblem();
                    p.parse(contents);
                    
                    //solve problem
                    SimplexSolver solver = new SimplexSolver();
                    solver.setModel(model);
                    Double res = solver.solve(p);
                    
                    if(res == Double.NaN)
                    {
                        model.addToBuffer("Le PL n a pas de solution !\n");
                    }
                    else
                    {
                        model.addToBuffer("PL resolution termine !\n");
                    }
                    
                    
                }} );
            
        }
        
        if(text == "Exemple Dual"){
            this.addActionListener(new ActionListener() {
                public void actionPerformed(ActionEvent e) {
                    
                    String contents =
                    "2;3;;\nmin;2;4;100\ntrue; true;;\n<=;2;1;10\n<=;3;2;5\n>=;2;5;8";
                    
                    //create new problem
                    SimplexProblem p = new SimplexProblem();
                    p.parse(contents);
                    
                    //solve problem
                    SimplexSolver solver = new SimplexSolver();
                    solver.setModel(model);
                    Double res = solver.solve(p);
                    
                    if(res == Double.NaN)
                    {
                        model.addToBuffer("Le PL n a pas de solution !\n");
                    }
                    else
                    {
                        model.addToBuffer("PL resolution termine !\n");
                    }
                    
                    
                }} );
            
        }
        
        if(text == "Dual"){
            this.addActionListener(new ActionListener() {
                public void actionPerformed(ActionEvent e) {
                    
                    
                    String contents = model.getNumOfIndependentVar()+";"+model.getNumOfConstraints()+";;\nmax;";
                    
                    for(int i = 0 ; i < model.getNumOfIndependentVar() ; i ++ ){
                        contents = contents+ (-(model.getMatrix().getValueAt(0,(i+1))))+";";
                    }
                    
                    contents = contents+"0\n true; true;;\n<=;";
                    
                    for(int i = 0 ; i < model.getNumOfConstraints() ; i ++ ){
                        for(int j = 0 ; j < model.getNumOfConstraints() ; j ++ ){
                            if( j != model.getNumOfConstraints()-1 )
                             contents = contents+model.getMatrix().getValueAt((i+1),(j+1))+";";
                            else{
                                if( j != model.getNumOfConstraints()-1 )
                                  contents = contents+model.getMatrix().getValueAt((i+1),(j+1));
                                else
                                    contents = contents+model.getMatrix().getValueAt((i+1),(0));

                            }
                        
                            
                        }
                        
                        if( i != model.getNumOfIndependentVar() )
                           contents = contents + "\n<=;";
                    }
                  
                    //create new problem
                    SimplexProblem p = new SimplexProblem();
                    p.parse(contents);
                    
                    //solve problem
                    SimplexSolver solver = new SimplexSolver();
                    solver.setModel(model);
                    Double res = solver.solve(p);
                    
                    if(res == Double.NaN)
                    {
                        model.addToBuffer("Le PL n a pas de solution !\n");
                    }
                    else
                    {
                        model.addToBuffer("PL resolution termine !\n");
                    }
                    
                    
                }} );
            
        }
        
        if(text == "Simplex"){
            this.addActionListener(new ActionListener() {
                public void actionPerformed(ActionEvent e) {
                    
                    double A[][] = new double[model.getNumOfConstraints()][model.getNumOfIndependentVar()] ;
                    double[] c = new double[model.getNumOfIndependentVar()];
                    double[] b = new double[model.getNumOfConstraints()];

                    for(int i = 0 ; i <  model.getNumOfConstraints() ; i++){
                        for(int j = 0 ; j <  model.getNumOfIndependentVar() ; j++){
                            A[i][j] = model.getMatrix().getValueAt((i+1),(j+1));
                            System.out.println("valA"+A[i][j]);
                        }
                    }
                    
                    for(int i = 0 ; i <  model.getNumOfIndependentVar() ; i++)
                        c[i] = -model.getMatrix().getValueAt((0),(i+1));
                    
                     for(int i = 0 ; i < model.getNumOfConstraints() ; i++)
                       b[i] = model.getMatrix().getValueAt((i+1),(0));
                         
                    
                    SimplexBland lp = new SimplexBland(A, b, c, model);
                    
                    model.addToBuffer("value = " + lp.value()+"\n\n");
                    
                    lp.solution();
                    
                    
                }} );
            
        }


			
	}
}
