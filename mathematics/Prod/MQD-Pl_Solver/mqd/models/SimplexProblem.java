
package models;

import com.sun.xml.ws.util.StringUtils;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;
import java.util.stream.Collectors;


public class SimplexProblem {
    private OptimisationType optimisationType;
    private SimplexCoefficient[] coefficients;
    private SimplexConstraint[] constraints;

    public SimplexProblem()
    {
    }

    public void parse(String data)
    {
        int j = 0;
        String[] values = Arrays.stream(data.replace("\n", ";").split(";"))
                .map(String::trim)
                .filter(s -> !s.isEmpty())
                .toArray(String[]::new);

        //lire variable
        int amountVariables = Integer.parseInt(values[j++]);
        int amountConstraints = Integer.parseInt(values[j++]);

        //init arrays
        coefficients = new SimplexCoefficient[amountVariables+1];
        constraints = new SimplexConstraint[amountConstraints];

        //lire type
        optimisationType = OptimisationType.valueOf(StringUtils.capitalize(values[j++]));

        //lire coefficients + d valeur
        for(int i = 0; i < amountVariables + 1; i++)
        {
            coefficients[i] = new SimplexCoefficient(Double.parseDouble(values[j++]));
        }

        //lire coef non neg
        for(int i = 0; i < amountVariables; i++)
        {
            coefficients[i].setNotNegative(Boolean.parseBoolean(values[j++]));
        }

        //lire contraintes
        for(int i = 0; i < amountConstraints; i++)
        {
            SimplexConstraint c = new SimplexConstraint(amountVariables);

            switch (values[j++])
            {
                case "<=":
                    c.setConstraintType(ConstraintType.LessThanEquals);
                    break;

                case "=":
                    c.setConstraintType(ConstraintType.Equals);
                    break;

                case ">=":
                    c.setConstraintType(ConstraintType.GreaterThanEquals);
                    break;
            }

            //lire coeff b & c
            for(int k = 0; k < amountVariables + 1; k++)
            {
                c.getCoefficients()[k] = (Double.parseDouble(values[j++]));
            }

            constraints[i] = c;
        }
    }

    public OptimisationType getOptimisationType() {
        return optimisationType;
    }

    public void setOptimisationType(OptimisationType optimisationType) {
        this.optimisationType = optimisationType;
    }

    public SimplexCoefficient[] getCoefficients() {
        return coefficients;
    }

    public SimplexConstraint[] getConstraints() {
        return constraints;
    }

    public double[] getSlackVariables()
    {
        double[] slackVars = new double[coefficients.length];

        for(int i = 0; i < coefficients.length; i++)
            slackVars[i] = coefficients[i].getValue();

        return slackVars;
    }

    public void convertInequation()
    {
        for(int i = 0; i < coefficients.length; i++)
        {
            coefficients[i].setValue(coefficients[i].getValue()*-1);
        }
    }

    public void convertEqualsConstraints()
    {
        ArrayList<SimplexConstraint> cons = new ArrayList<>();

        for(SimplexConstraint c : this.constraints)
        {
            if(c.getConstraintType() != ConstraintType.Equals) {
                cons.add(c);
                continue;
            }

            //est egal
            cons.add(new SimplexConstraint(c, ConstraintType.LessThanEquals));
            cons.add(new SimplexConstraint(c, ConstraintType.GreaterThanEquals));
        }

        SimplexConstraint[] s = new SimplexConstraint[cons.size()];
        this.constraints = cons.toArray(s);
    }
}
