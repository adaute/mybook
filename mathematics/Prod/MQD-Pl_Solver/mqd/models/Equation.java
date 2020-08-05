package models;

public class Equation {

    public static double[] plugIn(double[] equation, double[] values, int variable)
    {
        assert equation.length == values.length;

        double[] solution = new double[equation.length];

        //resoudre par var
        for(int i = 0; i < equation.length; i++)
        {
            solution[i] = equation[variable] * values[i];
        }

        //ajouter valeur equation
        for(int i = 0; i < equation.length; i++)
        {
            if(i != variable)
            {
                solution[i] += equation[i];
            }
        }

        return solution;
    }


    public static double[] shift(double[] equation, int variable)
    {
        double value = equation[variable] * -1;

        //reset : y1 = x1 + x2 ... + xn | -y1
        equation[variable] = -1;

        //valeurs normes
        for(int i = 0; i < equation.length; i++)
        {
            equation[i] /= value;
        }

        return equation;
    }
}
