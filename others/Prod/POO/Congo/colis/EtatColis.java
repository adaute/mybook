package congo.colis;

// enumeration des differents etats possible d'un colis, utilisé dans EtatTemporel

public enum EtatColis {
	PPC("Prêt à être pris en charge"),
	PC("Pris en charge"),
	PCD("Prise en charge par un drone"),
	L("Livré"),
	LC("Livraison confirmée");

	private final String text;

	private EtatColis(final String text) {
		this.text = text;
	}

	@Override
	public String toString() {
		return text;
	}
}