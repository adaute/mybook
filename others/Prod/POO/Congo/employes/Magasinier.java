package congo.employes;

import java.util.ArrayList;
import java.util.Date;
import congo.compagnie.*;
import congo.colis.*;

public class Magasinier extends Employe {

	public Magasinier(String n, String mdp)
	{
		super(n, mdp);
	}
	
	// crée un nouveau colis et lui ajoute l'état "pret a etre pris en charge"
	public Colis preparationColis(String ad, double p, ArrayList<ColisType> ind, Client c)
	{
		Colis co = new Colis(ad, p, c, ind, this.centre);
		co.ajouterEtat(EtatColis.PPC);
		return co;
	}
	
	// vérifie l'existence du colis, puis tente de l'assigner au drone et lui ajoute l'état "pris en charge par un drone" en cas de succès
	public boolean priseEnChargeDrone(Colis co, Drone d) 
	{
		if(d.getColis() == null)
		{
			if(d.setColis(co));
			{
				co.ajouterEtat(EtatColis.PCD);
				return true;
			}
		}
		return false;
	}
	
	// ajoute un produit non existant dans l'entreprise
	public void ajouterProduit(String descriptif, ProduitType type)
	{
		this.entreprise.ajouterProduit(descriptif, type);
	}
	
	// augmente la quantité d'un produit dans son centre
	public void ajouterProduits(Produit p, int q) 
	{
		this.centre.ajouterProduits(p,q);
	}
	
}