
import java.text.DecimalFormat;
import java.util.*;

@SuppressWarnings("serial")

// classe du Tab Simplex
public class Matrix {

	private int row;
	private int column;
	private ArrayList<ArrayList<Element>> table ;
	private boolean displayLastColumn = true ;
	
	public Matrix() {
		this(0,0);
	}
	
	public Matrix(int row,int column) {
		if(row<1 || column<1){
			this.row = 0;
			this.column = 0;			
		}else{
			this.row = row;
			this.column = column;			
		}
		this.createMatrixContent();
	}
	
	public Matrix(Matrix matrix){
		
		if(matrix==null || matrix.isEmpty()){
			clear();
		}else this.copy(matrix);
	}
	
	public boolean isEmpty() {
		return (this.row==0) || (this.column==0) || (this.table.isEmpty()) ;
	}
	
	public void setDimension(int row,int column){
		
		this.row = (row<1)? 0:row;
		
		if((this.row==0)){
			this.column = 0 ;
			if(!table.isEmpty()) table.clear();
		}else{
		
			this.column =  (column<1)? 0:column;
			if(this.column==0){				
				this.row = 0;
				if(!table.isEmpty())table.clear();
			}else{
				this.createMatrixContent();
			}
		}
	}
	
	public void setRowCount(int row){
		this.row = (row<1)? 0:row;
		
		if (this.row==0){
			this.column = 0;
			this.table.clear() ;
		} 
	}
	
	
	public int getRowCount() { return this.row; }
	
	
	public void setColumnCount(int column) {
		
		this.column = (column<1)? 0:column;
		
		if (this.column==0){
			this.row = 0;
			this.table.clear();
		}
	}
	
	public int getColumnCount() { return this.column; }
	
	public void setValueAt(int row,int column,double value){
		
			this.table.get(row).get(column).setValue(value) ;
	}
		
	public double getValueAt(int row,int column) {
		return this.table.get(row).get(column).getValue();
	}
	
	public void setElementAt(int row,int column,Element e){
		this.table.get(row).get(column).setElement(e);	
	}
	
	public Element getElementAt(int row,int column) {
		return this.table.get(row).get(column);
	}
	
	
	public void displayLastColumn(boolean display) {
		this.displayLastColumn = display ;
	}
	
	public void clear() {
		this.row = 0 ;
		this.column = 0 ;
		this.table.clear(); 
	}
		
	
	public void copy(Matrix matrix,int rowB,int rowE,int columnB,int columnE){
		boolean reinit = (matrix==null || matrix.isEmpty()) || (rowB<0 || rowE<0 || rowB>rowE) || (columnB<0 || columnE<0 || columnB>columnE);
		reinit = reinit || rowE > matrix.getRowCount()-1 || columnE > matrix.getColumnCount()-1 ;
		
		this.clear();
		if(!reinit) {
			int i,j;
			
			this.row = matrix.getRowCount();
			this.column = matrix.getColumnCount();
			
			this.createMatrixContent();		
			
			for(i=rowB;i<=rowE;i++)for(j=columnB;j<=columnE;j++)
				this.setElementAt(i, j, matrix.getElementAt(i, j));
		}
	}
	
	
	public void copy(Matrix matrix){
		if(matrix==null) this.clear();
		else this.copy(matrix, 0, matrix.getRowCount()-1, 0, matrix.getColumnCount()-1);
	}
	
	public void copyRowValues(ArrayList<Element> row,int indexRow) {
		
		if(row!=null && row.size()== this.column){
			int j;		
			for(j=0;j<this.column;j++){
				this.setValueAt(indexRow,j,row.get(j).getValue());
			}
		}
		
	}
	
	public void copyColumnValues(ArrayList<Element> column,int indexColumn) {
		
		if(column!=null && column.size()== this.row){
			int i;		
			for(i=0;i<this.row;i++){
				this.setValueAt(i,indexColumn,column.get(i).getValue());
			}
		}
		
	}
	
	public void createMatrixContent() {		
		int i,j;
		this.table = new ArrayList<ArrayList<Element>>();		
		for(i=0;i<this.row;i++){
			ArrayList<Element> ligne = new ArrayList<Element>(this.column);
			for(j=0;j<this.column;j++){
				ligne.add(new Element(i,j));
			}
			this.table.add(ligne);
		}		
	}

	public void initWith(double value,int rowB,int rowE,int columnB,int columnE){
			 int i,j;
			 for(i=rowB;i<=rowE;i++)for(j=columnB;j<=columnE;j++)
				  this.setValueAt(i, j, value);
	}
	
	
	public void initWith(Element e,int rowB,int rowE,int columnB,int columnE){
			 int i,j;
			 for(i=rowB;i<=rowE;i++)for(j=columnB;j<=columnE;j++)
				  this.setElementAt(i, j,e);	
	}
	
	public void setRowValues(ArrayList<Element> row,int indexRow){
		if(row!=null && row.size()== this.column){
			int j ;			
			for(j=0;j<this.column;j++) 
				setValueAt(indexRow, j, row.get(j).getValue());
		}
		
	}
	
	public ArrayList <Element> getRow(int indexRow) {
		if(indexRow<this.row && indexRow>=0) return table.get(indexRow);
		else return null;
	}
	
	public void setColumnValues(ArrayList<Element> column,int indexColumn){
		
		if(column!=null && column.size()== this.row){
			int i ;			
			for(i=0;i<this.row;i++) 
				setValueAt(i, indexColumn, column.get(i).getValue());
		}		
	}
	
	public ArrayList<Element> getColumn(int indexColumn) {
		if(indexColumn<this.column && indexColumn>=0){
			ArrayList<Element> colonne = new ArrayList<Element>();
			int i ;
			for(i=0;i<this.row;i++)
				colonne.add(this.getElementAt(i, indexColumn));
			return colonne;
		}else return null;
	}
	
	public void addRow(int indexRow,double value){
	
		int j;
		for(j=0;j<this.column;j++)
			setValueAt(indexRow, j,getValueAt(indexRow, j)+value);		
			
	}

	public void addRow(int indexRow,Element e){
		
		if(e!=null){
			int j;
			for(j=0;j<this.column;j++)
				setValueAt(indexRow, j,getValueAt(indexRow, j)+e.getValue());
		}
	}

	public void addRow(int indexRow,ArrayList<Element> row) {
		
		if(row!=null && row.size()== this.column){
			int j;
			for(j=0;j<this.column;j++)
				this.setValueAt(indexRow, j, getValueAt(indexRow, j)+row.get(j).getValue());
		}
	}
	
	
	public void addColumn(int indexColumn,double value){
	
		int i;
		for(i=0;i<this.row;i++)
			setValueAt(i,indexColumn ,getValueAt(i,indexColumn)+value);
	}	
	
	public void addColumn(int indexColumn,Element e){
		
		if(e!=null){
			int i;
			for(i=0;i<this.row;i++)
				setValueAt(i,indexColumn ,getValueAt(i,indexColumn)+e.getValue());
		}
		
	}
	
	public void addColumn(int indexColumn,ArrayList<Element> column) {
		
		if(column!=null && column.size()== this.row){
			int i;
			for(i=0;i<this.row;i++)
				this.setValueAt(i,indexColumn, getValueAt(i, indexColumn)+column.get(i).getValue());
		}
		
	}
	
	public void multiplyRow(int indexRow,double value){
		
		int j;
		for(j=0;j<this.column;j++)
			setValueAt(indexRow,j ,getValueAt(indexRow,j)*value);
		
	}
	
	public void multiplyRow(int indexRow,Element e){
		
		if(e!=null){
			int j;
			for(j=0;j<this.column;j++)
				setValueAt(indexRow,j ,getValueAt(indexRow,j)*e.getValue());
		}
		
	}
	
	public void multiplyRow(int indexRow,ArrayList<Element> row) {
		
		if(row!=null && row.size()== this.column){
			int j;
			for(j=0;j<this.column;j++)
				this.setValueAt(indexRow,j, getValueAt(indexRow,j)*row.get(j).getValue());
		}
	}
	
	public void multiplyColumn(int indexColumn,double value){
		
		int i;
		for(i=0;i<this.row;i++)
			setValueAt(i,indexColumn ,getValueAt(i,indexColumn)*value);
		
	}
	
	public void multiplyColumn(int indexColumn,Element e){
		
		if(e!=null){
			int i;
			for(i=0;i<this.row;i++)
				setValueAt(i,indexColumn ,getValueAt(i,indexColumn)*e.getValue());
		}
	}
	
	public void multiplyColumn(int indexColumn,ArrayList<Element> column) {
		
		if(column!=null && column.size()== this.row){
			int i;
			for(i=0;i<this.row;i++)
				this.setValueAt(i,indexColumn, getValueAt(i, indexColumn)*column.get(i).getValue());
		}
	}
	
	public int compareRowValues(int indexRow,ArrayList<Element> row) {
		if(row==null || row.size()!=this.column) return -2;
		else {			
			int j;
			double val;
			for(j=0;j<this.column;j++){				
				if( (val=row.get(j).getValue()- getValueAt(indexRow,j))!=0){
					 return (val < 0) ? 1:-1 ;
				}
			}			
			return 0;
		}
	}
	
	public int compareColumnValues(int indexColumn,ArrayList<Element> column) {
		if(column==null || column.size()!=this.row) return -2;
		else {			
			int i;
			double val;
			for(i=0;i<this.row;i++){				
				if( (val=column.get(i).getValue()- getValueAt(i,indexColumn))!=0){
					 return (val < 0) ? 1:-1 ;
				}
			}			
			return 0;
		}
	}

}
