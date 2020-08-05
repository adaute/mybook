package models;

public class SimplexCoefficient {
    private double value;
    private boolean isNotNegative;

    public SimplexCoefficient(double value)
    {
        this(value, true);
    }

    public SimplexCoefficient(double value, boolean isNotNegative)
    {
        this.value = value;
        this.isNotNegative = isNotNegative;
    }

    public double getValue() {
        return value;
    }

    public void setValue(double value) {
        this.value = value;
    }

    public boolean isNotNegative() {
        return isNotNegative;
    }

    public void setNotNegative(boolean notNegative) {
        isNotNegative = notNegative;
    }
}
