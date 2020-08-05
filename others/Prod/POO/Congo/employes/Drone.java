package congo.employes;

import java.util.Date;
import congo.compagnie.*;
import congo.colis.*;

public class Drone {

	private static int compteur = 0; //détermine l'id
	
	private final int id;
	private int portee;
	private int charge;
	private Entreprise entreprise;
	private Centre centre;
	private Colis colis;
	
	public Drone(int p, int ch)
	{
		this.id = compteur++;
		this.portee = p;
		this.charge = ch;
		this.entreprise = null;
		this.centre = null;
		this.colis = null;
	}
	
	// compare le poids du colis à la charge max du drone
	public boolean verifierPoids() 
	{
		if(this.colis != null)
			return colis.getPoids() <= this.charge;
		else
			return false;
	}
	
	//ajoute un Etat "livré" au colis
	public void livrer() 
	{	if(this.colis != null)
		{
			this.colis.ajouterEtat(EtatColis.L);
			this.colis = null;
		}
	}
	
	public int getId()
	{
		return this.id;
	}
	
	public int getPortee()
	{
		return this.portee;
	}
	
	public void setPortee(int p)
	{
		this.portee = p;
	}
	
	public int getCharge()
	{
		return this.charge;
	}
	
	public Colis getColis()
	{
		return this.colis;
	}
	
	public void setCharge(int ch)
	{
		this.charge = ch;
	}
	
	public Entreprise getEntreprise()
	{
		return this.entreprise;
	}
	
	public void setEntreprise(Entreprise e)
	{
		this.entreprise = e;
	}
	
	public Centre getCentre()
	{
		return this.centre;
	}
	
	public void setCentre(Centre c)
	{
		this.centre = c;
	}
	
	//vérifie le poids avant d'affecter le colis au drone, renvoie un boolean utilisé pour une méthode du magasinier
	public boolean setColis(Colis co) 
	{
		if(verifierPoids())
			this.colis = co;
		else
			return false;
			
		return true;
	}
	
}