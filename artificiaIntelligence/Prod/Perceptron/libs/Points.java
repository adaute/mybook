package libs;

public class Points {
	private double x1, x2;
	private int yt, y;
		
	public Points(double x1, double x2, int yt) {
		this.x1 = x1;
		this.x2 = x2;
		this.yt = yt;
		this.y = yt;
	}
	    
	public double getX1() {
		return x1;
	}

	public double getX2() {
		return x2;
	}

	public int getYt() {
		return yt;
	}
	    
	public int getY() {
		return y;
	}
	    
	public void setY(int y) {
		this.y = y;
	}
}

