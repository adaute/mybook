package congo.employes;

import java.util.ArrayList;
import congo.compagnie.*;

public class Responsable extends Employe {

	public Responsable(String n, String mdp)
	{
		super(n, mdp);
	}
	
	public ArrayList<Employe> rechercherEmploye(String recherche)
	{
		ArrayList<Employe> res = new ArrayList<Employe>();
		for (Employe e : this.entreprise.getEmployes())
		{
			if (e.getNom().toLowerCase().contains(recherche.toLowerCase()))
				res.add(e);			
		}
		return res;
	}
	
	//ajoute un employé à son centre si celui-ci n'est pas déja assigné
	public void ajouterEmploye(Employe e)
	{
		if(this.centre != null && e.getEntreprise() == this.getEntreprise() && e.getCentre() == null)
		{
			e.setCentre(this.centre);
			this.centre.ajouterEmploye(e);
		}
	}
	
	//retire l'employé de son centre s'il en fait partie
	public void supprimerEmploye(Employe e)
	{	
		if(this.centre != null)
		{
			ArrayList<Employe> employes = this.centre.getEmployes();
			if(employes.contains(e))
			{
				employes.remove(e);
				e.setCentre(null);
			}
		}
	}
	
	//ajoute un drone à son centre si celui-ci n'est pas déja assigné
	public void ajouterDrone(Drone d)
	{
		if(d.getEntreprise() == this.getEntreprise() && d.getCentre() == null)
		{
			d.setCentre(this.centre);
			this.centre.ajouterDrone(d);
		}
	}
	
	//retire le drone de son centre s'il en fait partie
	public void supprimerDrone(Drone d)
	{	
		if(this.centre != null)
		{
			ArrayList<Drone> drones = this.centre.getDrones();
			if(drones.contains(d))
			{
				drones.remove(d);
				d.setCentre(null);
			}
		}
	}
}