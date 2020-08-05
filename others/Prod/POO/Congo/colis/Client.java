package congo.colis;

import java.util.ArrayList;

public class Client {

	private static int compteur = 0;
	
	private final int id;
	private String adresse;
	private ArrayList<Colis> colis;
	
	public Client(String ad)
	{
		this.id = compteur++;
		this.adresse = ad;
		this.colis = new ArrayList<Colis>();
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
}