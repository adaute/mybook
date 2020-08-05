package congo.colis;

public class Produit {

	private static int compteur = 0;
	
	private final int id;
	private String descriptif;
	private ProduitType type; //catégorie du produit
	
	public Produit(String des, ProduitType t)
	{
		this.id = compteur++;
		this.descriptif = des;
		this.type = t;
	}
	
	public String toString()
	{
		return type.toString() + " " + descriptif;
	}
	
	public int getId()
	{
		return this.id;
	}
	
	public String getDescriptif()
	{
		return this.descriptif;
	}
	
	public void setDescriptif(String des)
	{
		this.descriptif = des;
	}
	
	public ProduitType getType()
	{
		return this.type;
	}
	
	public void setType(ProduitType t)
	{
		this.type= t;
	}
}