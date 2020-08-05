package view;

import java.util.*;
import java.awt.*;
import javax.swing.*;
import javax.swing.table.*;

import model.Model;
import libs.*;

public class VueTab extends JPanel implements Observer 
{
  private Model model;
  private JTable pointsTab;
  private DefaultTableModel pointsTabModel;
  
  public VueTab(Model model) {
    this.model = model;
	pointsTabModel = new DefaultTableModel(){
		public boolean isCellEditable(int iRowIndex, int iColumnIndex){
          return false;
		}
	};
	pointsTab = new JTable();
	
	ArrayList<String> header = new ArrayList<>();
	header.add("x1");
	header.add("x2");
    header.add("yt");
	header.add("y");
	header.add("Different");

    pointsTabModel.setColumnIdentifiers(header.toArray());
	pointsTab.setModel(pointsTabModel);

    pointsTab.getTableHeader().setReorderingAllowed(false);
	
	Box boxPBoutons = new Box(BoxLayout.Y_AXIS);   
	boxPBoutons.add(pointsTab.getTableHeader());
	boxPBoutons.add(pointsTab);
 
    add(boxPBoutons);
  }
  
  public void update(Observable source, Object donnees) {	
    if ((source instanceof Model) && (donnees != null)
		&& (donnees instanceof Boolean)) {
					
		if (pointsTabModel.getRowCount() > 0) {
			for (int i = pointsTabModel.getRowCount() - 1; i > -1; i--) 
				pointsTabModel.removeRow(i);
		}
		
		
		for (int i = 0 ; i < model.getData().size(); i++ ){

			pointsTabModel.addRow(
			new Object[]{
				model.getData().get(i).getX1(),
				model.getData().get(i).getX2(),
				model.getData().get(i).getYt(),
				model.getData().get(i).getY(),
				(model.getData().get(i).getYt() != model.getData().get(i).getY() ? "+" : ""),
				}
			);
		}
	           			
		pointsTab.setModel(pointsTabModel);
	}
  }
} 
