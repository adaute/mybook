package congo.employes;

import java.util.Date;
import congo.compagnie.*;
import congo.colis.*;

public class Livreur extends Employe {

	public Livreur(String n, String mdp)
	{
		super(n, mdp);
	}
	
	//ajoute un état "pris en charge" au colis
	public void priseEnCharge(Colis co)
	{
		co.ajouterEtat(EtatColis.PC);
	}
	
	//ajoute un état "livré" au colis
	public void livrer(Colis co) 
	{	
		co.ajouterEtat(EtatColis.L);
	}
}