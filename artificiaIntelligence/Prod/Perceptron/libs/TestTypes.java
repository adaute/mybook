package libs;

import java.awt.*;
import java.awt.event.*;
import javax.swing.*;

public class TestTypes{

	public static boolean isDoubleAndGood(String str) { //verifie si la valeur est un double correct (pour rate)
      try {
        double nbr = Double.parseDouble(str);
		if (nbr > 0.0 && nbr < 1.0)
			return true;
        return false;
      } catch (NumberFormatException e) {
        return false;
     }
  }
  
  public static boolean isIntegerAndGood(String str) { //verifie si la valeur est un integer correct (pour yt)
     try {
        int nbr =  Integer.parseInt(str);
		if (nbr == 0 || nbr == 1)
			return true;
        return false;
     } catch (NumberFormatException e) {
        return false;
     }
  }
  
   public static boolean isIntegerAndGoodIter(String str) { //verifie si la valeur est un itneger correct (pour le nombre d iterations)
     try {
        int nbr =  Integer.parseInt(str);
		if (nbr > 0 && nbr < 3000)
			return true;
        return false;
     } catch (NumberFormatException e) {
        return false;
     }
  }

}
  
  

