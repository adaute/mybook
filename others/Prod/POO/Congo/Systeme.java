package congo;

import java.util.ArrayList;
import congo.compagnie.*;
import congo.colis.*;
import congo.employes.*;

public class Systeme {

	public static void main(String[] args) {
	
		Entreprise Congo = new Entreprise("Congo");
		Centre c1 = new Centre("c1", "amiens", new Coordonnees(0,1,2));
		Centre c2 = new Centre("c2", "abbeville", new Coordonnees(1,2,3));
		
		Congo.ajouterProduit("Oral B Pro 6000 Tintin", ProduitType.BROSSEADENTS);
		Congo.ajouterProduit("Tintin au Congo", ProduitType.LIVRE);
		
		Magasinier m1 = new Magasinier("Jean", "toto");
		Livreur l1 = new Livreur("Jack", "titi");
		Responsable r1 = new Responsable("Antoine", "tutu");
		
		Congo.ajouterCentre(c1);
		Congo.ajouterCentre(c2);
		
		m1.setEntreprise(Congo);
		l1.setEntreprise(Congo);
		r1.setEntreprise(Congo);
		
		c1.ajouterEmploye(r1);
		r1.ajouterEmploye(l1);
		r1.ajouterEmploye(m1);
		
		Colis co = m1.preparationColis("31 rue pomme", 52.5, null, new Client("31 rue pomme"));
		l1.priseEnCharge(co);
		l1.livrer(co);
		Congo.confirmerReception(co);
		
		for(EtatTemporel e : co.getEtats())
		{
			System.out.println("Colis " + co.getId() + ": " + e.getEtat()+ " - " + e.getDate());
		}
		

   }
}