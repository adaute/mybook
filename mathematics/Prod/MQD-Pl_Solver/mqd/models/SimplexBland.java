package models;
import java.util.*;

import models.Model;


public class SimplexBland {
    private static final double EPSILON = 1.0E-8;
    private double[][] a;   // tableau simplex
    private int M;          // contraintes
    private int N;          // variables
    
    private int[] basis;
    
    private Model model;
    
    public SimplexBland(double[][] A, double[] b, double[] c, Model model) {
        // remplir tableau
        M = b.length;
        N = c.length;
        
        this.model = model;
        
        a = new double[M+1][N+M+1];
        for (int i = 0; i < M; i++)
            for (int j = 0; j < N; j++)
                a[i][j] = A[i][j];
        for (int i = 0; i < M; i++) a[i][N+i] = 1.0;
        for (int j = 0; j < N; j++) a[M][j]   = c[j];
        for (int i = 0; i < M; i++) a[i][M+N] = b[i];
        
        basis = new int[M];
        
        for (int i = 0; i < M; i++)
             basis[i] = N + i;
    
        
        solve();
        
        // verifier les conditions
        assert check(A, b, c);
    }
    
    private void solve() {
        while (true) {
            
            // q : colonne entrante
            int q = bland();
            if (q == -1) break;  // optimal
            
            // p : colonne sortante
            int p = minRatioRule(q);
            if (p == -1) throw new ArithmeticException("PL non borne \n");
            
            // pivot
            pivot(p, q);
            
            basis[p] = q;
            
            show();
        }
    }
    
    // cout positif avec le plus petit indice
    private int bland() {
        for (int j = 0; j < M + N; j++)
            if (a[M][j] > 0) return j;
        return -1;  // optimal
    }
    
    
    // min ratio
    private int minRatioRule(int q) {
        int p = -1;
        for (int i = 0; i < M; i++) {
            if (a[i][q] <= 0) continue;
            else if (p == -1) p = i;
            else if ((a[i][M+N] / a[i][q]) < (a[p][M+N] / a[p][q])) p = i;
        }
        return p;
    }
    
    // pivot (p, q)  Gauss-Jordan elimination
    private void pivot(int p, int q) {
        
        // appliquer le facteur
        for (int i = 0; i <= M; i++)
            for (int j = 0; j <= M + N; j++)
                if (i != p && j != q) a[i][j] -= a[p][j] * a[i][q] / a[p][q];
        
        // zero sur colonne q
        for (int i = 0; i <= M; i++)
            if (i != p) a[i][q] = 0.0;
        
        // ligne p
        for (int j = 0; j <= M + N; j++)
            if (j != q) a[p][j] /= a[p][q];
        a[p][q] = 1.0;
    }
    
    // return objectif optimal
    public double value() {
        return -a[M][M+N];
    }
    
    
    // extraire la solution en Ax = b
    public void solution() {
        
        for(int i = 0 ; i < M ; i++){
            for(int j = 0 ; j < M+N ; j++){
                if(a[i][j] == 1)
                    model.addToBuffer("x[" + (j+1) + "] = " + a[i][N+M] +"\n");
            
            }
        }
        
        model.addToBuffer("\n Dictionnaire : \n");
        model.addToBuffer(" Z "+value()+" ");
        
        for(int i = 0 ; i < M ; i++){
            for(int j = 0 ; j < M+N ; j++){
                if(a[i][j] == 1)
                    i++;
                else model.addToBuffer("x"+(j+1)+"  ");
                
            }
        }
        
        model.addToBuffer("\n");
                
        for(int i = 0 ; i < M ; i++){
            for(int j = 0 ; j < M+N ; j++){
                if(a[i][j] == 1 ){
                    model.addToBuffer(" x" + (j+1)+" " + a[i][N+M]);
                    
                    j = 0 ;
                    while(j != M+N ){
                        if(a[i][j] != 0 && a[i][j] != 1)
                            model.addToBuffer(" "+ a[i][j]+" ");
                        
                        j++;
                    }
                }
                
            }
            
           model.addToBuffer("\n");
        }

    
    }
    
    
    // extraire la solution en Ax = b
    public double[] primal() {
        double[] x = new double[N];
        for (int i = 0; i < M; i++)
            if (basis[i] < N) x[basis[i]] = a[i][M+N];
        return x;
    }
    
    // extraire la  solution to yA = 0, yb != 0
    public double[] dual() {
        double[] y = new double[M];
        for (int i = 0; i < M; i++)
            y[i] = -a[M][N+i];
        return y;
    }
    
    
    // primal faisable ?
    private boolean isPrimalFeasible(double[][] A, double[] b) {
        double[] x = primal();
        
        // verifier x >= 0
        for (int j = 0; j < x.length; j++) {
            if (x[j] < 0.0) {
                model.addToBuffer("x[" + j + "] = " + x[j] + " est negatif \n");
                return false;
            }
        }
        
        // verifier Ax <= b
        for (int i = 0; i < M; i++) {
            double sum = 0.0;
            for (int j = 0; j < N; j++) {
                sum += A[i][j] * x[j];
            }
            if (sum > b[i] + EPSILON) {
                model.addToBuffer("primal non faisable \n");
                model.addToBuffer("b[" + i + "] = " + b[i] + ", sum = " + sum +"\n");
                return false;
            }
        }
        return true;
    }
    
    // dual faisable ?
    private boolean isDualFeasible(double[][] A, double[] c) {
        double[] y = dual();
        
        // verifier y >= 0
        for (int i = 0; i < y.length; i++) {
            if (y[i] < 0.0) {
                model.addToBuffer("y[" + i + "] = " + y[i] + " est negatif \n");
                return false;
            }
        }
        
        // verifier yA >= c
        for (int j = 0; j < N; j++) {
            double sum = 0.0;
            for (int i = 0; i < M; i++) {
                sum += A[i][j] * y[i];
            }
            if (sum < c[j] - EPSILON) {
                model.addToBuffer("dual non faisable \n");
                model.addToBuffer("c[" + j + "] = " + c[j] + ", somme = " + sum + "\n");
                return false;
            }
        }
        return true;
    }
    
    // verifier valeur optimal  = cx = yb
    private boolean isOptimal(double[] b, double[] c) {
        double[] x = primal();
        double[] y = dual();
        double value = value();
        
        // verifier value = cx = yb
        double value1 = 0.0;
        for (int j = 0; j < x.length; j++)
            value1 += c[j] * x[j];
        double value2 = 0.0;
        for (int i = 0; i < y.length; i++)
            value2 += y[i] * b[i];
        if (Math.abs(value - value1) > EPSILON || Math.abs(value - value2) > EPSILON) {
            model.addToBuffer("valeur = " + value + ", cx = " + value1 + ", yb = " + value2 + "\n");
            return false;
        }
        
        return true;
    }
    
    private boolean check(double[][]A, double[] b, double[] c) {
        return isPrimalFeasible(A, b) && isDualFeasible(A, c) && isOptimal(b, c);
    }
    
    
    // ecrire tableaux
    public void show() {
        for (int i = 0; i <= M; i++) {
            for (int j = 0; j <= M + N; j++) {
                model.addToBuffer(String.valueOf(a[i][j])+"   ");
            }
            model.addToBuffer("\n");
        }
        model.addToBuffer("\nvaleur = " + value()+"\n\n");
        
    }
    
}
