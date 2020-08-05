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

public class SimplexTab extends JPanel{
    private JTable table;
    private JPanel tablePanel;

	public SimplexTab(Model model) {
		table = new JTable();

		String[] columnNames = new String[2+model.getNumOfIndependentVar()+model.getNumOfConstraints()];
		columnNames[0] = new String("Membres dt");
		columnNames[1+model.getNumOfIndependentVar()+model.getNumOfConstraints()] = new String("Var b");
		
		String idVar = "X";
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

		tablePanel = new JPanel(new BorderLayout());
        tablePanel.add(table, BorderLayout.CENTER);
        tablePanel.add(table.getTableHeader(), BorderLayout.NORTH);

		add(tablePanel);			
    }


	class SimplexeTableModel extends DefaultTableModel {
		
		
	}

			
}


