package congo.colis;;

//représente la quantité d'un produit dans un centre ou un colis

public class NombreProduits{
	
	private Produit produit;
	private int quantite;
	
	public NombreProduits(Produit p, int q)
	{
		this.produit = p;
		this.quantite = q;
	}
	
	public String toString() {
		return this.quantite + " " + this.produit.getDescriptif();
	}
	
	public Produit getProduit()
	{
		return this.produit;
	}
	
	public void setProduit(Produit p)
	{
		this.produit = p;
	}
	
	public int getQuantite()
	{
		return this.quantite;
	}
	
	public void setQuantite(int q)
	{
		this.quantite = q;
	}
}