package congo.compagnie;

import java.util.ArrayList;
import congo.employes.*;
import congo.colis.*;

public class Entreprise{

	private static int compteur = 0;
	
	private final int id;
	private String nom;
	private ArrayList<Centre> centres;
	private ArrayList<Employe> employes;
	private ArrayList<Drone> drones;
	private ArrayList<Produit> produits;
	
	public Entreprise(String n)
	{
		this.id = compteur++;
		this.nom = n;
		centres = new ArrayList<Centre>();
		employes= new ArrayList<Employe>();
		drones = new ArrayList<Drone>();
		produits = new ArrayList<Produit>();
	}
	
	// ajoute un centre et crée un stock (objet NombreProduits) pour chacun des produits de l'entreprise, initialisé à 0
	public void ajouterCentre(Centre c) 
	{
		if(!this.centres.contains(c))
		{
			centres.add(c);
		
			for (Produit p : produits)
			{
				c.ajouterProduit(p);
			}
		
			c.setEntreprise(this);
		}
	}
	
	// crée un nouveau produit
	public void ajouterProduit(String descriptif, ProduitType type)
	{	
		Produit p = new Produit(descriptif, type);
		ajouterProduit(p);
	}
	
	// teste si le produit est déjà présent dans la liste. Si non, l'ajoute et crée un stock pour ce produit dans chaque centre de l'entreprise
	public void ajouterProduit(Produit p)
	{
		if(!this.produits.contains(p))
			produits.add(p);
		
		for (Centre c : centres)
		{
			c.ajouterProduit(p);
		}
	}
	
	// renvoie une liste de produits dont le descriptif contient une chaine de caractères spécifique
	public ArrayList<Produit> rechercherProduit(String recherche)
	{
		ArrayList<Produit> res = new ArrayList<Produit>();
		for (Produit p : produits)
		{
			if (p.getDescriptif().toLowerCase().contains(recherche.toLowerCase()))
				res.add(p);			
		}
		return res;
	}
	
	//recherche un colis dans chaque centre de l'entreprise
	public Colis getColis(int id)
	{
		for (Centre c : centres)
		{
			for (Colis co : c.getColis())
			{
				if (co.getId() == id)
					return co;
			}
		}
		return null;
	}
	
	// ajoute un etat "livraison confirmée" au colis
	public void confirmerReception(Colis co)
	{
		co.ajouterEtat(EtatColis.LC);
	}
	
	public String getNom()
	{
		return this.nom;
	}
	
	public void setNom(String n)
	{
		this.nom = n;
	}
	
	public ArrayList<Centre> getCentres()
	{
		return this.centres;
	}
	
	public ArrayList<Employe> getEmployes()
	{
		return this.employes;
	}
	
	public ArrayList<Drone> getDrones()
	{
		return this.drones;
	}
	
	public ArrayList<Produit> getProduits()
	{
		return this.produits;
	}
}