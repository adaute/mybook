
import java.util.*;
import javax.swing.*;
import javax.swing.event .*;
import java.awt.*;
import java.awt.event.*;

public class ZoneLignes extends JTextField implements Observer {
	
	private Model model;
	
	public ZoneLignes(Model model) {
		super(String.valueOf(model.getX()) ,2);
		this.model=model;
		
			this.addFocusListener(new FocusListener(){
				public void focusGained(FocusEvent e) {
				}

       			public void focusLost(FocusEvent e) {
					if(!getText().equals(""))
						model.setX(Integer.parseInt(getText()));
					else
						setText(String.valueOf(model.getX()));
       			}
       		});
			
			this.addMouseListener( new  MouseAdapter(){
			 public void mousePressed(MouseEvent e) {
			     setText("");
			   }
			});
	}
	
	public void update(Observable source, Object donnees) {
		if ((source instanceof Model) && (donnees != null) && (donnees instanceof String))
		{ 
			this.setText(donnees.toString());
		}
	}
}
