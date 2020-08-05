import javax.swing.*;
import javax.swing.event .*;
import java.awt.event.*;
import java.lang.String;

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
			
	}
}