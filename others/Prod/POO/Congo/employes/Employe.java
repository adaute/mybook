package congo.employes;

import java.util.ArrayList;
import congo.compagnie.*;
import congo.colis.*;

public abstract class Employe{
	
	private static int compteur = 0; //détermine l'id
	
	protected final int id;
	protected String nom;
	protected String mdp;
	protected Entreprise entreprise;
	protected Centre centre;
	
	public Employe(String n, String mdp)
	{
		this.id = compteur++;
		this.nom = n;
		this.mdp = mdp;
		this.entreprise = null;
		this.centre = null;
	}
	
	//retourne une liste de produits contenant la chaîne dans leur nom
	public ArrayList<Produit> rechercherProduit(String recherche) 
	{
		return this.entreprise.rechercherProduit(recherche);
	}
	
	public int getId()
	{
		return this.id;
	}
	
	public String getNom()
	{
		return this.nom;
	}
	
	public void setNom(String n)
	{
		this.nom = n;
	}
	
	public String getMdp()
	{
		return this.mdp;
	}
	
	public void setMdp(String mdp)
	{
		this.mdp = mdp;
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
}