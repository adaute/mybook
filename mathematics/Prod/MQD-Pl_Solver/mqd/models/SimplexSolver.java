
package models;

import java.util.Arrays;
import models.Model;


public class SimplexSolver {

    private double[][] schema;
    private int aimIndex;
    private int cIndex;

    //equation identifier
    private String[] head;
    private String[] side;
    
    public Model model;
    
    public void setModel (Model m){
        this.model = m;
    }
    
    public Double solve(SimplexProblem problem)
    {

        // convertir egal
        problem.convertEqualsConstraints();

        // convertir <=
        for(SimplexConstraint c : problem.getConstraints())
        {
            if (c.getConstraintType() == ConstraintType.GreaterThanEquals)
                c.convertInequation();
        }

        // max ou min
        if(problem.getOptimisationType() == OptimisationType.Min)
            problem.convertInequation();

        // variable haut et gauche
        head = new String[problem.getCoefficients().length - 1];

        for (int i = 0; i < head.length; i++)
            head[i] = "x" + (i + 1);

        side = new String[problem.getConstraints().length];

        for (int i = 0; i < side.length; i++)
            side[i] = "y" + (i + 1);

        //tab simplex
        schema = new double[problem.getConstraints().length+1][problem.getCoefficients().length];

        aimIndex = schema.length-1;
        cIndex = schema[aimIndex].length-1;

        //init tab
        for(int y = 0; y < aimIndex; y++)
            schema[y] = problem.getConstraints()[y].getSlackVariables();

        schema[aimIndex] = problem.getSlackVariables();

        // check nbr cycle
        long maxSteps = getMaxIterations(problem.getCoefficients().length - 2, problem.getConstraints().length);

        printSchema("Initial");

        //check algorithme dual
        int negCCount = getNegativeCCount();
        if(negCCount > 0)
        {
            dualAlgorithm(negCCount);
        }

        //lancer algo
        int stepCount = 0;
        while (nextStep(stepCount++)){
            if(stepCount > maxSteps)
            {
                //quitter cycle
                model.addToBuffer("Cycle probleme ! Pas de solution !\n");
                return null;
            }
        }

        model.addToBuffer("\n");
        
        //solve head functions
        for (int i = 0; i < head.length; i++) {
            String xName = "x" + (i + 1);
            int index = getIndexOf(xName);
            model.addToBuffer(xName + " = " + schema[index][cIndex]+ "\n");
        }

        if(negCCount > 0)
        {
            schema[aimIndex][cIndex] *= -1;
        }

        //show result
        model.addToBuffer("Result: " + schema[aimIndex][cIndex]+"\n");
        model.addToBuffer("\n");
        return schema[aimIndex][cIndex];
    }

    private int getNegativeCCount()
    {
        int c = 0;

        boolean[] negC = getNegativeC();
        for(int i = 0; i < negC.length; i++)
        {
            if (negC[i])
                c++;
        }

        return c;
    }


    private boolean[] getNegativeC()
    {
        boolean[] isNegative = new boolean[schema.length-1];
        for(int i = 0; i < schema.length - 1; i++)
        {
            isNegative[i] = schema[i][cIndex] < 0;
        }

        return isNegative;
    }

    private boolean nextStep(int stepCount)
    {
        //position prochain element
        MatrixPos aimFunctionPos = getPositiveAimFunctionComponent();

        //End si Null
        if(aimFunctionPos == null)
            return false;

        model.addToBuffer("Colonne (" + aimFunctionPos.x + "): " + schema[aimIndex][aimFunctionPos.x]+"\n");

        //plus petit quotient (ci / aiq)
        MatrixPos pivotIndex = getPositionOfSmallestQuotient(aimFunctionPos.x);

        model.addToBuffer("Pivot (" + pivotIndex.y + "|" + pivotIndex.x + "): " + schema[pivotIndex.y][pivotIndex.x]+"\n");

        swap(pivotIndex);

        printSchema("Etape " + stepCount);
        return true;
    }

    private void swap(MatrixPos pivotIndex)
    {
        //deplacer pivot
        schema[pivotIndex.y] = Equation.shift(schema[pivotIndex.y], pivotIndex.x);

        //swap nom variable
        swapVariableName(pivotIndex.y, pivotIndex.x);

        // resoudre tout sauf elt pivot
        double[] values = schema[pivotIndex.y];
        for(int y = 0; y < schema.length; y++)
        {
            if(y != pivotIndex.y) {
                double[] eq = schema[y];
                schema[y] = Equation.plugIn(eq, values, pivotIndex.x);
            }
        }
    }

    private MatrixPos getPositionOfSmallestQuotient(int x)
    {
        double min = Double.MAX_VALUE;
        int bestY = -1;

        for(int y = 0; y < aimIndex; y++)
        {
            double aiq = schema[y][x];

            //bq sup ou egal a 0
            if (aiq >= 0)
                continue;

            double q = Math.abs(schema[y][cIndex] / aiq);
            if(q < min)
            {
                min = q;
                bestY = y;
            }
        }

        assert bestY != -1;

        //return pivot elt
        return new MatrixPos(bestY, x);
    }

    private MatrixPos getPositiveAimFunctionComponent()
    {
        for(int x = 0; x < cIndex; x++)
        {
            if(schema[aimIndex][x] > 0)
                return new MatrixPos(aimIndex, x);
        }

        model.addToBuffer("pas de nouveau elt a switch! \n");
        return null;
    }

    private void printSchema()
    {
        printSchema("Schema");
    }

    private void swapVariableName(int s, int h) {
        String tmp = side[s];
        side[s] = head[h];
        head[h] = tmp;
    }

    private int getIndexOf(String varName) {
        for (int i = 0; i < aimIndex; i++)
            if (side[i].equals(varName))
                return i;

        return 0;
    }

    private void printSchema(String message)
    {
        model.addToBuffer(message + ": \n");

        //ecrire header
        model.addToBuffer("\t");
        for (int i = 0; i < head.length; i++)
            model.addToBuffer(head[i]+"\t");
        model.addToBuffer("\n");

        //ecrire line
        model.addToBuffer("\t");
        for (int i = 0; i < head.length; i++)
            model.addToBuffer("--"+"\t");
        model.addToBuffer("\n");

        //ecrire data
        for(int y = 0; y < schema.length; y++)
        {
            if(y == schema.length-1)
                model.addToBuffer("z  | \t");
            else
               model.addToBuffer(side[y] + " | \t");

            for(int x = 0; x < schema[y].length; x++)
            {
                model.addToBuffer(String.valueOf(schema[y][x])+"\t");
            }
            model.addToBuffer("\n");
        }

        model.addToBuffer("\n");
    }

    private void dualAlgorithm(int negCCount)
    {
        model.addToBuffer("PL solvable uniquement par algorithme dual!\n\n");

        //sauvegarder z et ajouter h et cIndex
        double[] saveZ = schema[aimIndex].clone();
        int saveCIndex = cIndex;

        schema[aimIndex] = new double[schema[aimIndex].length];

        for(int n = 0; n < negCCount; n++) {

            for (int i = 0; i < schema.length; i++) {
                schema[i] = SimplexUtil.insertAt((schema[i]), 0, 1);

                if(i == aimIndex)
                {
                    head = SimplexUtil.insertAt(head, 0, "q"+n);
                    cIndex++;
                }
            }
        }

        schema[aimIndex][0] = -1;

        //print
        printSchema("Schema dual");

        //switch negative c's
        boolean[] negativeC = getNegativeC();
        int ci = 0;
        for(int i = negativeC.length - 1; i >= 0; i--)
        {
            if(negativeC[i])
            {
                swap(new MatrixPos(i,ci));
                ci++;
            }
        }

        printSchema("Pre Simplex Dual");

        int stepCount = 0;
        while (nextStep(stepCount++)){}

        model.addToBuffer("Arret Dual! \n");


        for(int i = 0; i < head.length; i++)
        {
            if(head[i].startsWith("q"))
            {
                for(int j = 0; j < schema.length; j++)
                {
                    schema[j] = SimplexUtil.removeAt(schema[j], i);
                }

                head = SimplexUtil.removeAt(head, i);
                i--;
            }
        }

        int indexX1 = getIndexOf("x1");
        schema[aimIndex] = Equation.plugIn(saveZ, schema[indexX1], 0);

        cIndex = saveCIndex;

        printSchema("Dual-Fixe Simplex Schema");
    }

    private long getMaxIterations(int varCount, int inequationCount)
    {
        int n = varCount + inequationCount;
        int k = inequationCount;

        return faculty(n) / (faculty(n-k) * faculty(k));
    }

    private long faculty(int n)
    {
        long m = 1;
        for (int i = 1; i <= n; i++) {
            m *= i;
        }
        return m;
    }
}
