package congo.colis;

import java.util.ArrayList;
import java.util.Date;
import congo.compagnie.*;
import congo.employes.*;

public class Colis {

	private static int compteur = 0; //détermine l'id
	
	private final int id;
	private String adresse;
	private double poids;
	private Client client;
	private Centre centre;
	private ArrayList<EtatTemporel> etats; // EtatTemporel : Etat (enumeration de String, ex : "Livré") + Date
	private ArrayList<ColisType> indications; // ColisType : enumeration de String (ex: "fragile")
	private ArrayList<NombreProduits> contenu; // NombreProduits : un produit + une quantité
	
	public Colis(String ad, double p, Client c, ArrayList<ColisType> ind)
	{
		this.id = compteur++;
		this.adresse = ad;
		this.poids = p;
		this.client = c;
		this.centre = null;
		this.etats = new ArrayList<EtatTemporel>();
		this.indications = ind;
		this.contenu = new ArrayList<NombreProduits>();
	}
	
	public Colis(String ad, double p, Client c, ArrayList<ColisType> ind, Centre ce)
	{
		this.id = compteur++;
		this.adresse = ad;
		this.poids = p;
		this.client = c;
		this.centre = ce;
		this.etats = new ArrayList<EtatTemporel>();
		this.indications = new ArrayList<ColisType>();
		this.contenu = new ArrayList<NombreProduits>();
	}
	
	//ajoute un produit et une quantité
	public void ajouterProduits(Produit p, int q)
	{
		this.contenu.add(new NombreProduits(p,q));
	}
	
	//rajoute un EtatTemporel au colis consistant d'un état de colis et de la date présente
	public void ajouterEtat(EtatColis ec)
	{
		this.etats.add(new EtatTemporel(this, ec, new Date()));
	}
	
	public void ajouterIndication(ColisType i)
	{
		this.indications.add(i);
	}
	
	public int getId()
	{
		return this.id;
	}
	
	public String getAdresse()
	{
		return this.adresse;
	}
	
	public void setAdresse(String ad)
	{
		this.adresse = ad;
	}
	
	public double getPoids()
	{
		return this.poids;
	}
	
	public void setPoids(double p)
	{
		this.poids = p;
	}
	
	public Centre getCentre()
	{
		return this.centre;
	}
	
	public void setCentre(Centre c)
	{
		this.centre = c;
	}
	
	public ArrayList<EtatTemporel> getEtats()
	{
		return this.etats;
	}
}