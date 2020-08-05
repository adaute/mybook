package congo.compagnie;

//coordonnes geographique des centres

public class Coordonnees {

	private static int compteur = 0;
	
	protected final int id;
	private int latitude;
	private int longitude;
	private int altitude;
	
	public Coordonnees(int lat, int lon, int alt)
	{
		this.id = compteur++;
		this.latitude = lat;
		this.longitude = lon;
		this.altitude = alt;
	}
	
	public int getId()
	{
		return this.id;
	}
	
	public int getLatitude()
	{
		return this.latitude;
	}
	
	public int getLongitude()
	{
		return this.longitude;
	}
	
	public int getAltitude()
	{
		return this.altitude;
	}
	
	public void setLatitude(int lat)
	{
		this.latitude = lat;
	}
	
	public void setLongitude(int lon)
	{
		this.longitude = lon;
	}
	
	public void setAltitude(int alt)
	{
		this.altitude = alt;
	}
}