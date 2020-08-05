package views;

import java.util.*;
import javax.swing.*;
import javax.swing.event .*;
import java.awt.*;
import java.awt.event.*;
import java.awt.Component;
import javax.swing.table.AbstractTableModel;
import javax.swing.table.DefaultTableCellRenderer;
import javax.swing.table.DefaultTableModel;
import javax.swing.table.TableCellRenderer;
import javax.swing.table.TableColumn;
import models.Model;

public class SimplexTab extends JPanel{
    public JTable table;
    public JPanel tablePanel;
    public Model model;
    public int selectedRow=-1,selectedColumn=-1,select=0 ;

	public SimplexTab(Model model) {
		this.model = model;
		this.table = new JTable();
        createTable();
		tablePanel = new JPanel(new BorderLayout());
        tablePanel.add(table, BorderLayout.CENTER);
        tablePanel.add(table.getTableHeader(), BorderLayout.NORTH);
		add(tablePanel);			
    }

    public void createTable() {
    	String[] columnNames = new String[2+model.getNumOfIndependentVar()+model.getNumOfConstraints()];
		columnNames[0] = new String("Membres dt");
		columnNames[1+model.getNumOfIndependentVar()+model.getNumOfConstraints()] = new String("Var b");
		
		String idVar = "x";
		int i,j,k;
		
		for(i=1;i<=(model.getNumOfIndependentVar()+model.getNumOfConstraints());i++)
			columnNames[i] = new String(idVar+i);			
		
		SimplexeTableModel modelTab = new SimplexeTableModel(); 
		modelTab.setColumnIdentifiers(columnNames);
		
		int count = 1+model.getNumOfIndependentVar()+model.getNumOfConstraints();
		k = model.getNumOfIndependentVar()+1;
		
		for(i=0;i<= model.getNumOfConstraints();i++){
			Vector <Object> row = new Vector<Object>();
			for(j=0;j<count;j++){
				if(i!=0 && ( (j-model.getNumOfIndependentVar())==i ) ) row.add("1");
				else row.add("0");
			}
			if(i==0) row.add("Z");
			else row.add(columnNames[k++]);
			modelTab.addRow(row);
		}

		table.setModel(modelTab);
		table.setColumnSelectionAllowed(false);
		table.setRowSelectionAllowed(false);
		table.setDefaultRenderer(Object.class, new SimplexeTableRender());
    }


    public void simplexTabMaj(Model model) {
    	createTable();

    	int i,j;

    	for(i = 0 ; i < model.getMatrix().getRowCount() ; i++){
    	   for(j = 0 ; j < model.getMatrix().getColumnCount() ; j++){
    	    	if(j == model.getMatrix().getColumnCount()-1)
    	      	   		table.setValueAt( String.valueOf(model.getMatrix().getElementAt(i,j).getName()), i, j);
    	      	   	else
    	      	   		table.setValueAt( String.valueOf(model.getMatrix().getValueAt(i,j)), i, j);
    	   }
    	}	

    }


	class SimplexeTableModel extends DefaultTableModel {
		@Override
		public boolean isCellEditable(int ligne, int colonne){
			return colonne!=(1+model.getNumOfIndependentVar()+model.getNumOfConstraints()) ;
		}
		
	}

	class  SimplexeTableRender  extends DefaultTableCellRenderer{		
		@Override
		public Component getTableCellRendererComponent(JTable table, Object value, boolean isSelected, boolean hasFocus, int row, int column){			
			this.setValue(value);
			setBackground(Color.WHITE);
			if(select==1 && row==selectedRow) setBackground(Color.ORANGE);
			if(select==1 && column==selectedColumn) setBackground(Color.ORANGE);
			if(select==2 &&row==selectedRow && column==selectedColumn) setBackground(Color.CYAN);
			if(select==3 &&row==selectedRow && column==selectedColumn) setBackground(Color.GREEN);
			return this;
		}		
		
	}

	public void repaintTable(int rowPivot,int columnPivot,long time) throws InterruptedException {
		
		/* Selection de la colonne pivot */
		select = 1 ;
		selectedColumn = columnPivot ;
		table.repaint();
		model.addToBuffer("\n--- Selection de la colonne "+(columnPivot+1)+" comme colonne pivot\n");
		Thread.sleep(time);
		
		/* Selection de la ligne pivot */
		selectedRow = rowPivot ;
		table.repaint();
		model.addToBuffer("\n--- Selection de la ligne "+(rowPivot+1)+" comme ligne pivot\n");
		Thread.sleep(time);
		
		/* Selection de la cellule pivot */
		select = 2 ;
		table.repaint();
		model.addToBuffer("\n--- Coordonnee de l'element pivot ("+(rowPivot+1)+","+(columnPivot+1)+"). \n");
		Thread.sleep(time);
		
		table.repaint();
	}

	public void majVariable(int select, int selectedColumn, int selectedRow){
		this.select = select;
		this.selectedColumn =  selectedColumn;
		this.selectedRow = selectedRow;
	}

	public JTable getTable(){
		return this.table;
	}

    public void setTable(JTable table){
	   this.table = table;
	}
			
}


