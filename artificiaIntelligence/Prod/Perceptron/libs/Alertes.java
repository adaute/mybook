package libs;

import java.awt.*;
import java.awt.event.*;
import javax.swing.*;

public class Alertes{
	
	public static void setAlertError(String message, String titre) { //permet d afficher des messages d'erreur
		JOptionPane.showMessageDialog(
			 null,
		 	 message,
			 titre,
			 JOptionPane.ERROR_MESSAGE);
	}
	
	public static int setYesNoAsk(String message, String titre){ //permet d afficher des messages de confirmation
		int n = JOptionPane.showConfirmDialog(
			null,
			message,
			titre,
			JOptionPane.YES_NO_OPTION);
			
		return n;
	}

}
  
  

