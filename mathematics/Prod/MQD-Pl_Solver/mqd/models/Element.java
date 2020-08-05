package models;

import java.text.DecimalFormat;

@SuppressWarnings("serial")

// classe permettant de gerer les elements du tableau simplex
public class Element {
	
	private int row ;
	private int column ;
	private double value;
	private String name ;
	
	// nbr d'elt de la classe
	private static int count = -1 ;
	
	public Element(int row,int column,double value,String name){
		this.row = row ;
		this.column = column ;
		this.value = round(value,2) ;
		this.name = name ;
		Element.count++;
	}
	
	public Element() {
		this(-1,-1,0,null);
	}
	
	public Element(int row,int column) {
		this(row,column,0,null);
	}
	
	public Element(int row,int column,double value) {
		this(row,column,value,null);
	}
	
	public Element(int row,int column,String name) {
		this(row,column,0,name);
	}
	
	// reset compteur
	public static void reinitCount() { count=-1;}

	
	public int getRow() { return this.row ; }
	
	public int getColumn() { return this.column ; }
	
	public double getValue() { return this.value ; }

	public String getName() { return this.name ; }

	
	public void setName(String name) { this.name = name ; }
	
	public void setValue(double value) { this.value = round(value,2) ; }
	
	public void setColumn(int column) { this.column = column ; }

	public void setRow(int row) { this.row = row ;}

	public void setElement(Element e){
		if(e==null){
			this.row = -1 ;
			this.column = -1;
			this.value = 0;
			this.name = null;
		}else{			
			this.row = e.getRow() ;
			this.column = e.getColumn();
			this.value = round(e.getValue(),2);
			this.name = e.getName();
		}
	}

	public static double round(double number,int order) {	
		double rounded ;		
		
		if(order<0) return number ;
		if(order==0) Math.round(number);
		
		String decimalFormat ="0.";			
		for(int i=1;i<=order;i++) decimalFormat+="0";		
		DecimalFormat format  = new DecimalFormat(decimalFormat);
		rounded = Double.parseDouble(format.format(number).replace(',', '.'));
		return rounded ;
	}

	public String toString(){
		DecimalFormat nombre = new DecimalFormat("0.00");
		if(name!=null)return this.name+" = "+nombre.format(this.value);
		if(this.row!=-1 && this.column!=-1) return "("+this.row+","+this.column+") = "+ nombre.format(this.value) ;
		return ""+nombre.format(this.value);
	}
	
}
