package models;

import java.util.*;
import views.*;

public class Simplex {

	private ArrayList<SimplexeIteration> iterations = null;
	private int current = -1 ;
	private boolean executed;

	public Simplex(Matrix m,int variablesNumber,int constraintsNumber) {		
		reinit(m,variablesNumber,constraintsNumber);
	}	
	
	public void execute() {
		if(!executed){
			int current=0 ;
			while(!iterations.get(current).isOptimalMatrix()){
				iterations.get(current).setIterationNumber(current+1);
				iterations.get(current).applySimplexe();
				if(!iterations.get(current).isOptimalSolution()){
					SimplexeIteration iteration = new SimplexeIteration(iterations.get(current).getResultMatrix(),iterations.get(current).getVaraiblesNumber(),iterations.get(current).getConstraintsNumber());					
					iterations.add(iteration);					
					current++ ;
				}else break;
			}
			executed = true;
		}
		
	}

	public void reinit(Matrix m,int variablesNumber,int constraintsNumber) {
		
		if(iterations!=null){
			int i;
			for(i=iterations.size()-1;i>=0;i--) iterations.remove(i);
			iterations = null ;
		}
		
		iterations = new ArrayList<SimplexeIteration> ();
		SimplexeIteration iteration = new SimplexeIteration(m,variablesNumber,constraintsNumber);
		current = 0 ;
		iteration.setIterationNumber(current);
		iterations.add(iteration);		
		executed = false ;
	}
	
	public boolean isFirstIteration() {
		return current==0;
	}
	
	public boolean isLastIteration() {
		return current==(this.iterations.size()-1);
	}
	
	
	public void setCurrent(int current){
		this.current = current ;
	}	

	public SimplexeIteration getCurrentIteration() {
		if(current!=-1) return this.iterations.get(current);
		return null;
	}
	
	public int getIterationCount() { return iterations.size(); }
	

	public SimplexeIteration firstIteration() {
		if(iterations.size()>0) {
			current = 0 ;
			return iterations.get(current);
		}
		current = -1 ;
		return null;
	}

	public SimplexeIteration nextIt() {
			if(current<(iterations.size()-1)) current++;
			return iterations.get(current);
	}
	
	public SimplexeIteration previousIt(){		
			if(current>0) current--;
			return iterations.get(current);
	}

	
	public SimplexeIteration nextIteration() {
		if(current!=-1){
			if(current<(iterations.size()-1)) current++;
			return iterations.get(current);
		}
		return null;
	}
	
	public SimplexeIteration previousIteration(){		
		if(current!=-1){
			if(current>0) current--;
			return iterations.get(current);
		}
		return null;
	}
	
	public SimplexeIteration lastIteration() {
		if(iterations.size()>0) {
			current = iterations.size()-1 ;
			return iterations.get(current);
		}
		current = -1 ;
		return null;
	}
	
	public String traceExecution(int index){
		return traceExecution(index,index);
	}
	
	public String  traceExecution(int indexB,int indexE){
		String value = "\n --- Execution de la methode du simplexe --- \n";
		int i;
		for(i=indexB;i<=indexE;i++){
			value+=iterations.get(i);
		}
		return value;	
	}
	
	public String toString(){
		return this.traceExecution(0,iterations.size()-1);
	}
	
}
