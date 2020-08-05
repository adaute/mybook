

import java.util.*;
import javax.swing.*;
import javax.swing.event .*;
import java.awt.*;
import java.awt.event.*;

public class GaussJordan{
	
    private static final double EPSILON = 1e-8;
    private final int N;      // Taille du systeme
    private final int C;      // Taille du systeme
    private final int N2;
	private double[][] matTab;
    private Model model;

	public GaussJordan(Model model,Matrix A, Matrix b){
		this.model = model;
        this.N = A.getColumnCount();
        this.C = A.getRowCount();
        if(A.getColumnCount() == A.getRowCount())
            this.N2 = A.getColumnCount();
        else
            this.N2 = 1;

        CreateMatrice(A,b);
	}

	public void CreateMatrice(Matrix A, Matrix b){
        
        matTab = new double[C][N+(N2)+1];
   
        for (int i = 0; i < C ; i++){
            for (int j = 0; j < N; j++){
                  matTab[i][j] = A.getValueAt(i,j);
            }
        }
        
        if(A.getColumnCount() == A.getRowCount()){
            for (int i = 0; i < C ; i++)
            matTab[i][C + i] = 1.0;
        }
        
        
        for (int i = 0; i < C ; i++)
            matTab[i][C + N2] = b.getValueAt(i,0);
        
	}
    
    public void showMatrix () {
        for (int i = 0; i < C ; i++) {
            for (int j = 0; j < N; j++) {
                model.addToBuffer(String.valueOf(matTab[i][j])+"   ");
            }
              if(this.N == this.C){
                model.addToBuffer("|   ");
                for (int j = C ; j < C + N2; j++) {
                 model.addToBuffer(String.valueOf(matTab[i][j])+"    ");
               }
             }

             model.addToBuffer("|   "+ String.valueOf(matTab[i][C+N2]));
            
             model.addToBuffer("\n");
        }
        model.addToBuffer("\n");
    }
  
    public void GaussJordan() { resoudre_system(); }
    
    /* trouver la ligne du pivot partiel */
    public int pivot(int p) {
        int max = p;
        for (int i = p+1; i < C ; i++) {
            if (Math.abs(matTab[i][p]) > Math.abs(matTab[max][p])) {
                max = i;
            }
        }
        return max;
    }
    
    public void resoudre_system() {
        int max ;
        
        
        // Gauss-Jordan elimination
        for (int p = 0; p < C ; p++) {
            
            max = pivot(p);
            
            // echanger ligne p avec colonne max
            swap(p, max);
            
            if (Math.abs(matTab[p][p]) <= EPSILON) {
                continue;
            }
            
            // pivot
            resoudre_systeme_pivot(p, p);
            
        }
        
         afficher_systeme_lineaire();
        
         model.addToBuffer("Solution Ax = b \n");
        
         solution();
   
    }
    
    public void swap(int l1, int l2) {
        double[] temp = matTab[l1];
        matTab[l1] = matTab[l2];
        matTab[l2] = temp;
    }
    
    public void matrice_pivotage(int p, int q ,  double[][] matTab) {
        
        int flag = 0;
        
        for (int i = 0; i < C ; i++) {
            double factor = matTab[i][q] / matTab[p][q];
            for (int j = 0; j <= N+(N2); j++) {
                if (i != p && j != q){
                    matTab[i][j] -= factor * matTab[p][j];
                    flag = 1;
                }
            }
            
            if(flag==1) {
                if (i != p){
                    matTab[i][q] = 0.0;
                }
                
                showMatrix();
            }
        }
        
        for (int j = 0; j <= N+(N2); j++)
            if (j != q) matTab[p][j] /= matTab[p][q];

        
        matTab[p][q] = 1.0;
        
        showMatrix();
        
    }
    
    // pivot on entry (p, q) using Gauss-Jordan elimination
    public void resoudre_systeme_pivot(int p, int q) {
        
        model.addToBuffer("Pivot("+p+","+q+"): "+matTab[q][p]+"\n\n");
        
        showMatrix();
        
        model.addToBuffer("matrice pivotage \n\n");
        
        matrice_pivotage(p,q,matTab);
        
    }
    
    public void afficher_systeme_lineaire() {
        
        model.addToBuffer("\n System lineaire : \n");
        
        for (int i = 0; i < C ; i++){
            for (int j = 0; j < N+1 ; j++){
                if(j < N-1)
                 model.addToBuffer("("+matTab[i][j]+") x"+(j+1)+" + ");
                else{
                    if(j == N-1 )
                        model.addToBuffer("("+matTab[i][j]+") x"+(j+1));
                    else
                        model.addToBuffer(" = "+matTab[i][j]);
                }
            }
            model.addToBuffer("\n");
        }
        model.addToBuffer("\n");

    }
    
    // extract solution to Ax = b
    public void solution() {
        if(this.C == this.N){
             double[] x = new double[C];
        for (int i = 0; i < C ; i++) {
            if (Math.abs(matTab[i][i]) > EPSILON)
                x[i] = matTab[i][N+N2] / matTab[i][i];
            else if (Math.abs(matTab[i][N+N2]) > EPSILON)
                return;
         }
        
        for (int i = 0; i < x.length; i++)
            model.addToBuffer("\n"+x[i]);
        }else{
            
            
            for (int i = 0; i < C ; i++){
                for (int j = 0; j < N ; j++){
                    if(i == j)
                      model.addToBuffer("("+matTab[i][j]+") X"+(j+1)+" = "+ matTab[i][3] +" + ");
                    else{
                        if(matTab[i][j] != 0){
                            if(j != N-1){
                                model.addToBuffer("("+ -(matTab[i][j]) +") x"+(j+1)+" + ");
                            }else
                                model.addToBuffer("("+ -(matTab[i][j]) +") x"+(j+1)+" ");
                        }
                    }

                }
                model.addToBuffer("\n");
            }
        }
        
    }


   	
}
