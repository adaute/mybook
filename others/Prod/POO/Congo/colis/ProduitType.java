package congo.colis;

//énumération des différents type de produits

public enum ProduitType {
	LIVRE("Livre"),
	CASSEROLE("Casserole"),
	BROSSEADENTS("Brosse à dents");

	private final String text;

	private ProduitType(final String text) {
		this.text = text;
	}

	@Override
	public String toString() {
		return text;
	}
}