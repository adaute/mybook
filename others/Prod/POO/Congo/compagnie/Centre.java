package congo.compagnie;

import java.util.ArrayList;
import congo.employes.*;
import congo.colis.*;

public class Centre {
	
	private static int compteur = 0;
	
	private final int id;
	private String nom;
	private String adresse;
	private Coordonnees coordonnees;
	private Entreprise entreprise;
	private ArrayList<Employe> employes;
	private ArrayList<Drone> drones;
	private ArrayList<NombreProduits> stocks;
	private ArrayList<Colis> colis;

	
	public Centre(String n, String ad, Coordonnees coo)
	{
		this.id = compteur++;
		this.nom = n;
		this.adresse = ad;
		this.coordonnees = coo;
		this.entreprise = null;
		this.employes = new ArrayList<Employe>();
		this.stocks = new ArrayList<NombreProduits>();
		this.colis = new ArrayList<Colis>();
	}
	
	//ajoute un nouveau stock (produit + quantité), initialisé à 0
	public void ajouterProduit(Produit p)
	{
		this.stocks.add(new NombreProduits(p,0));
	}
	
	//augmente la quantité d'un produit
	public void ajouterProduits(Produit p, int q)
	{
		for (NombreProduits n : stocks)
		{
			if(n.getProduit() == p)
			{
				n.setQuantite(n.getQuantite()+q);
				return;
			}
		}
	}
	
	public void ajouterEmploye(Employe e)
	{
		if(e.getCentre() == null)
		{
			this.employes.add(e);
			e.setCentre(this);
		}
	}
	
	public void ajouterDrone(Drone d)
	{
		this.drones.add(d);
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
	
	public String getAdresse()
	{
		return this.adresse;
	}
	
	public void setAdresse(String ad)
	{
		this.adresse = ad;
	}
	
	public Entreprise getEntreprise()
	{
		return this.entreprise;
	}
	
	public void setEntreprise(Entreprise e)
	{
		this.entreprise = e;
	}
	
	public ArrayList<Employe> getEmployes()
	{
		return this.employes;
	}
	
	public ArrayList<Drone> getDrones()
	{
		return this.drones;
	}
	
	public ArrayList<NombreProduits> getStocks()
	{
		return this.stocks;
	}
	
	public ArrayList<Colis> getColis()
	{
		return this.colis;
	}
}