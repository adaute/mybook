package congo.colis;

import java.util.Date;

public class EtatTemporel {
	private Colis colis;
	private EtatColis etat;
	private Date date;
	
	public EtatTemporel(Colis co, EtatColis et, Date d)
	{
		this.colis = co;
		this.etat = et;
		this.date = d;
	}
	
	public Colis getColis()
	{
		return this.colis;
	}
	
	public EtatColis getEtat()
	{
		return this.etat;
	}
	
	public Date getDate()
	{
		return this.date;
	}
}