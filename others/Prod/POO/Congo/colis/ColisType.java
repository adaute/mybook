package congo.colis;

public enum ColisType {

	F("Fragile"),
	U("Urgent"),
	R("Recommandé"),
	P("Prioritaire");

	private final String text;

	private ColisType(final String text) {
		this.text = text;
	}

	@Override
	public String toString() {
		return text;
	}
}