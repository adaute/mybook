package logoparsing;

import org.antlr.v4.runtime.ParserRuleContext;
import org.antlr.v4.runtime.tree.ParseTree;
import org.antlr.v4.runtime.tree.ParseTreeProperty;
import org.antlr.v4.runtime.tree.TerminalNode;

import javafx.scene.canvas.GraphicsContext;
import logogui.Log;
import logogui.LogoVar;
import logogui.Traceur;
import logoparsing.LogoParser.AvContext;
import logoparsing.LogoParser.BcContext;
import logoparsing.LogoParser.BoolContext;
import logoparsing.LogoParser.CosContext;
import logoparsing.LogoParser.DonneContext;
import logoparsing.LogoParser.ExprContext;
import logoparsing.LogoParser.FccContext;
import logoparsing.LogoParser.FloatContext;
import logoparsing.LogoParser.FonctionContext;
import logoparsing.LogoParser.FposContext;
import logoparsing.LogoParser.HasardContext;
import logoparsing.LogoParser.IfContext;
import logoparsing.LogoParser.LcContext;
import logoparsing.LogoParser.Liste_argumentsContext;
import logoparsing.LogoParser.LoopContext;
import logoparsing.LogoParser.MoveContext;
import logoparsing.LogoParser.MultContext;
import logoparsing.LogoParser.Operation_boolContext;
import logoparsing.LogoParser.ParentheseContext;
import logoparsing.LogoParser.PourContext;
import logoparsing.LogoParser.ProcedureContext;
import logoparsing.LogoParser.ReContext;
import logoparsing.LogoParser.RepeteContext;
import logoparsing.LogoParser.SinContext;
import logoparsing.LogoParser.StoreContext;
import logoparsing.LogoParser.SumContext;
import logoparsing.LogoParser.TdContext;
import logoparsing.LogoParser.TgContext;
import logoparsing.LogoParser.VariableContext;
import logoparsing.LogoParser.VeContext;
import logoparsing.LogoParser.WhileContext;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class LogoTreeVisitor extends LogoBaseVisitor<Integer> {
	Traceur traceur;
	ParseTreeProperty<Double> exprs = new ParseTreeProperty<>();
	ParseTreeProperty<Boolean> bools = new ParseTreeProperty<>();
	
	LogoVar vartab = new LogoVar();
	
	ArrayList<LogoProcedure> procedures = new ArrayList<>();
	LogoProcedure current_proc = new LogoProcedure();

	public LogoTreeVisitor() {
		super();
	}

	public void initialize(GraphicsContext gc) {
		traceur = new Traceur();
		traceur.setGraphics(gc);
	}

	public void setExprValue(ParseTree node, double value) {
		exprs.put(node, value);
	}
	
	public double getExprValue(ParseTree node) {
		Double value = exprs.get(node);
		if (value == null) {
			throw new NullPointerException();
		}
		return value;
	}
	
	public void setBoolValue(ParseTree node, boolean value) {
		bools.put(node, value);
	}
	
	public boolean getBoolValue(ParseTree node) {
		Boolean value = bools.get(node);
		if (value == null) {
			throw new NullPointerException();
		}
		return value;
	}

	@Override
	public Integer visitAv(AvContext ctx) {
		Log.appendnl("visitAv");
		try {
			Binome expr = evaluate(ctx.expr());
			if (expr._1 == 0) {
				traceur.avance(expr._2);
			} else
				return expr._1;
		} catch (NullPointerException ex) {
			ex.printStackTrace();
		}
		return 0;
	}

	@Override
	public Integer visitTd(TdContext ctx) {
		Log.appendnl("visitTd");
		try {
			Binome expr = evaluate(ctx.expr());
			if (expr._1 == 0) {
				traceur.td(expr._2);
			} else
				return expr._1;
		} catch (NullPointerException ex) {
			ex.printStackTrace();
		}
		return 0;
	}
	
	@Override
	public Integer visitTg(TgContext ctx){
		Log.appendnl("visitTg");
		try {
			Binome expr = evaluate(ctx.expr());
			if (expr._1 == 0) {
				traceur.tg(expr._2);
			} else
				return expr._1;
		} catch (NullPointerException ex) {
			ex.printStackTrace();
		}
		return 0;
	}
	
	@Override
	public Integer visitLc(LcContext ctx) {
		Log.appendnl("visitLc");
		try {
			traceur.lc();
		} catch (NullPointerException ex) {
			ex.printStackTrace();
		}
		return 0;
	}

	@Override
	public Integer visitBc(BcContext ctx) {
		Log.appendnl("visitBc");
		try {
			traceur.bc();
		} catch (NullPointerException ex) {
			ex.printStackTrace();
		}
		return 0;
	}

	@Override
	public Integer visitVe(VeContext ctx) {
		Log.appendnl("visitVe");
		try {
			traceur.ve();
		} catch (NullPointerException ex) {
			ex.printStackTrace();
		}
		return 0;
	}

	@Override
	public Integer visitRe(ReContext ctx) {
		Log.appendnl("visitRe");
		try {
			Binome expr = evaluate(ctx.expr());
			if (expr._1 == 0) {
				traceur.recule(expr._2);
			} else
				return expr._1;
		} catch (NullPointerException ex) {
			ex.printStackTrace();
		}
		return 0;
	}

	@Override
	public Integer visitFpos(FposContext ctx) {
		Log.appendnl("visitFpos");
		ArrayList<Binome> bins = new ArrayList<Binome>();
		try {
			for(int i = 0; i<ctx.expr().size(); i++) {
				Binome expr = evaluate(ctx.expr().get(i));
				if (expr._1 == 0) {
					bins.add(expr);
				} else
					return expr._1;
			}
		} catch (NullPointerException ex) {
			ex.printStackTrace();
		}

		traceur.fpos(bins.get(0)._2, bins.get(1)._2);
		return 0;
	}

	@Override	
	 public Integer visitFcc(FccContext ctx) { // TODO Auto-generated method stub
		Log.appendnl("visitFcc"); 
	    traceur.fcc(evaluate(ctx.expr(0))._2, evaluate(ctx.expr(1))._2, evaluate(ctx.expr(2))._2);
		return 0;
    }	 

	@Override
	public Integer visitFloat(FloatContext ctx) {
		Log.appendnl("visitFloat");
		String fText = ctx.FLOAT().getText();
		setExprValue(ctx, Float.parseFloat(fText));
		return 0;
	}

	@Override
	public Integer visitRepete(RepeteContext ctx) {
		Log.appendnl("visitRepete");
		try {
			Binome expr = evaluate(ctx.expr());
			double loop;
			if (expr._1 == 0){
				loop = expr._2;
				for (int i = 0; i < loop; ++i){
					setExprValue(ctx.liste_instructions(), i+1);
					visit(ctx.liste_instructions());
				}
			}
			else
				return expr._1;
		} 
		catch (NullPointerException ex) {ex.printStackTrace();}
		return 0;
	}

	@Override
	public Integer visitLoop(LoopContext ctx) {
		Log.appendnl("visitLoop");
		try {
			ParserRuleContext prc = ctx;
			while (!prc.getClass().toString().contains("Liste_instructionsContext"))
				prc = prc.getParent();
			double loop = getExprValue(prc);
			setExprValue(ctx, loop);
		}
		catch (NullPointerException ex) {ex.printStackTrace();}
		return 0;
	}

	@Override
	public Integer visitMult(MultContext ctx) {
		Log.appendnl("visitMult");
		Binome left, right;
		try {
			left = evaluate(ctx.expr(0));
			right = evaluate(ctx.expr(1));
			if (left._1 == 0 && right._1 == 0){
				Double result = left._2;
				Double result2 = right._2;
				
				if (result2 == 0 && ctx.getChild(1).getText().equals("/")){
					throw new ArithmeticException("Div par zero interdite !");
				}
				else {
					Double total = ctx.getChild(1).getText().equals("*") ?
					result * result2 : result / result2;
					
					setExprValue(ctx, total);
				}
			}
			else{
				if (left._1 != 0)
					return left._1;
				else
					return right._1;
			}
		} 
		catch (NullPointerException ex) {ex.printStackTrace();}
		catch (ArithmeticException ex2 ){ex2.printStackTrace();}

		return 0;
	}

	@Override
	public Integer visitParenthese(ParentheseContext ctx) {
		try {
			Binome expr = evaluate(ctx.expr());
			if (expr._1 == 0) //evaluation reussie
				setExprValue(ctx, expr._2);
			else
				return expr._1;
		} 
		catch (NullPointerException ex) {ex.printStackTrace();}
		return 0;
	}

	@Override
	public Integer visitSum(SumContext ctx) {
		Log.appendnl("visitSum");
		Binome left, right;
		try {
			left = evaluate(ctx.expr(0));
			right = evaluate(ctx.expr(1));
			if (left._1 == 0 && right._1 == 0){
				Double result = left._2;
				Double result2 = right._2;
				
				Double total = ctx.getChild(1).getText().equals("+") ?
				result + result2 : result - result2;
				
				setExprValue(ctx, total);
			}
			else{
				if (left._1 != 0)
					return left._1;
				else
					return right._1;
			}
		} 
		catch (NullPointerException ex) {ex.printStackTrace();}
		return 0;
	}

	@Override
	public Integer visitHasard(HasardContext ctx) {
		Log.appendnl("visitHasard");
		try {
			Binome expr = evaluate(ctx.expr());
			if (expr._1 == 0){//evaluation reussie
				double rnd = Math.random()*expr._2;
				setExprValue(ctx, rnd);
			}
			else
				return expr._1;
		} 
		catch (NullPointerException ex) {ex.printStackTrace();}
		return 0;
	}

	@Override
	public Integer visitCos(CosContext ctx) {
		Log.appendnl("visitCos");
		try {
			Binome expr = evaluate(ctx.expr());
			if (expr._1 == 0){//evaluation reussie
				setExprValue(ctx, Math.cos(Math.toRadians(expr._2)));
			}
			else
				return expr._1;
		} 
		catch (NullPointerException ex) {ex.printStackTrace();}
		return 0;
	}

	@Override
	public Integer visitSin(SinContext ctx) {
		Log.appendnl("visitSin");
		try {
			Binome expr = evaluate(ctx.expr());
			if (expr._1 == 0){//evaluation reussie
				setExprValue(ctx, Math.sin(Math.toRadians(expr._2)));
			}
			else
				return expr._1;
		} 
		catch (NullPointerException ex) {ex.printStackTrace();}
		return 0;
	}
	
	@Override
	public Integer visitStore(StoreContext ctx) {
		Log.appendnl("visitStore");
		try {
			traceur.store();
		} 
		catch (NullPointerException ex) {ex.printStackTrace();}
		return 0;
	}

	@Override
	public Integer visitMove(MoveContext ctx) {
		Log.appendnl("visitStore");
		try {
			traceur.move();
		} 
		catch (NullPointerException ex) {ex.printStackTrace();}
		return 0;
	}
	

	@Override
	public Integer visitDonne(DonneContext ctx) {
		Log.appendnl("visitDonne");
		try {
			Binome expr = evaluate(ctx.expr());
			if (expr._1 == 0){//evaluation reussie
				vartab.getVariables().peek().put(ctx.STRING().toString(), expr._2);
			}
			else
				return expr._1;
		} 
		catch (NullPointerException ex) {ex.printStackTrace();}
		return 0;
	}

	@Override
	public Integer visitVariable(VariableContext ctx) {
		Log.appendnl("visitVariable");
		
		String mavariable = ctx.STRING().toString();
		try {
			Map<String, Double> var = vartab.getVariables().peek();
			if (var.containsKey(mavariable))
				setExprValue(ctx, var.get(mavariable));
			else
				Log.appendnl("La variable " + mavariable + " n'existe pas");
		} 
		catch (NullPointerException ex) {ex.printStackTrace();}
		return 0;
	}

	@Override
	public Integer visitOperation_bool(Operation_boolContext ctx) {
		Log.appendnl("visitOperation_bool");
		
		try {
			Binome expr = evaluate(ctx.expr(0));
			Binome expr2 = evaluate(ctx.expr(1));

			if (expr._1 == 0 && expr2._1 == 0 ){//evaluation reussie
				
				switch (ctx.getChild(1).getText()){
				case "<" :
					if(expr._2 <  expr2._2) 
						setBoolValue(ctx, true);
					else
						setBoolValue(ctx, false);
					break;
				case ">" :
					if(expr._2 >  expr2._2) 
						setBoolValue(ctx, true);
					else
						setBoolValue(ctx, false);
					break;
				case "=" :
					if(expr._2 == expr2._2) 
						setBoolValue(ctx, true);
					else
						setBoolValue(ctx, false);
					break;
				case ">=" :
					if(expr._2 >=  expr2._2) 
						setBoolValue(ctx, true);
					else
						setBoolValue(ctx, false);
					break;
				case "<=" :
					if(expr._2 <=  expr2._2) 
						setBoolValue(ctx, true);
					else
						setBoolValue(ctx, false);
					break;
				case "<>" :
					if(expr._2 !=  expr2._2) 
						setBoolValue(ctx, true);
					else
						setBoolValue(ctx, false);
					break;
					default :	
				}
			}
			else
				return expr._1;
		} 
		catch (NullPointerException ex) {ex.printStackTrace();}
		return 0;

	}

	@Override
	public Integer visitBool(BoolContext ctx) {
		Log.appendnl("visitBool");
		String fText = ctx.BOOLEAN().getText();
		setBoolValue(ctx, Boolean.parseBoolean(fText));
		return 0;
	}

	@Override
	public Integer visitIf(IfContext ctx) {
		Log.appendnl("visitIf");
		try {
			BinomeBool expr = evaluateBool(ctx.expr_bool());
			if (expr._1 == 0){
				if(getBoolValue(ctx.expr_bool())){
					visit(ctx.liste_instructions(0)); 
				}
				else {
					if(ctx.liste_instructions().size() == 2) {
						visit(ctx.liste_instructions(1)); 
					}
				}
			}
			else
				return expr._1;
		} 
		catch (NullPointerException ex) {ex.printStackTrace();}
		return 0;		
	}

	@Override
	public Integer visitWhile(WhileContext ctx) {
		Log.appendnl("visitWhile");
		try {
			BinomeBool expr = evaluateBool(ctx.expr_bool());
			if (expr._1 == 0){
				while(getBoolValue(ctx.expr_bool())){
					visit(ctx.liste_instructions()); 
					if(evaluateBool(ctx.expr_bool())._1 == 0) {
						setBoolValue(ctx, evaluateBool(ctx.expr_bool())._2);
					}else {
						return expr._1;
					}
				}
			}
			else
				return expr._1;
		} 
		catch (NullPointerException ex) {ex.printStackTrace();}
		return 0;	
	}

	private Binome evaluate(ParseTree expr) {
		Binome res = new Binome();
		res._1 = visit(expr);
		res._2 = res._1 == 0 ? getExprValue(expr) : Double.POSITIVE_INFINITY;
		return res;
	}

	private BinomeBool evaluateBool(ParseTree expr) {
		BinomeBool res = new BinomeBool();
		res._1 = visit(expr);
		res._2 = res._1 == 0 ? getBoolValue(expr) : null;
		return res;
	}
	
	private class Binome {
		public Integer _1; // bilan
		public Double _2;  // valeur de l'expression si bilan = 0
	}
	
	private class BinomeBool {
		public Integer _1; // bilan
		public Boolean _2;  // valeur de l'expression si bilan = 0
	}

	
	
	@Override
	public Integer visitProcedure(ProcedureContext ctx) {
		Log.appendnl("visitProcedure");
		String proc_name = ctx.calling_procedure().STRING().getText();
		LogoProcedure procedure_called = null;
		
		try {
			for (LogoProcedure proc : procedures) {
				if (proc.getName().equalsIgnoreCase(proc_name)) {
					procedure_called = proc;
					break;
				}
			}
			
			if (procedure_called == null)
				Log.appendnl("La procedure "+proc_name+" n'existe pas");
			if( ctx.calling_procedure().expr().size() != procedure_called.getVariables().size())
				Log.appendnl("Nombre d'arguments pour la procedure '"+procedure_called.getName()+"' invalide");
			else{
				Log.appendnl("Appel de la procedure "+procedure_called.getName()+" OK");
				Map<String, Double> map = new HashMap<>();
				Binome argument;
				int i = 0;
				for (ExprContext exp : ctx.calling_procedure().expr() ) {
					argument = evaluate(exp);
					if (argument._1 == 0) { //evaluation reussie pour argument i
						map.put(procedure_called.getVariables().get(i++), argument._2);
					}
					else
						return argument._1;
				}
				
				vartab.getVariables().push(map);
				
				if (procedure_called.getList_instructions() != null)
					visit(procedure_called.getList_instructions());
				
				vartab.getVariables().pop();
			}
				
		}catch (NullPointerException ex) {ex.printStackTrace();}
				
		return 0;
	}

	@Override
	public Integer visitFonction(FonctionContext ctx) {
		Log.appendnl("visitFonction");
		String proc_name = ctx.calling_fonction().STRING().getText();
		LogoProcedure procedure_called = null;
		
		try {
			for (LogoProcedure proc : procedures) {
				//Log.appendnl("procVerif = " +proc.getName());
				if (proc.getName().equalsIgnoreCase(proc_name)) {
					procedure_called = proc;
					break;
				}
			}
			
			if (procedure_called == null)
				Log.appendnl("La fonction "+proc_name+" n'existe pas");
			if( ctx.calling_fonction().expr().size() != procedure_called.getVariables().size())
				Log.appendnl("Nombre d'arguments pour la fonction '"+procedure_called.getName()+"' invalide");
			else{
				Log.appendnl("Appel de la fonction "+procedure_called.getName()+" OK");
				Map<String, Double> map = new HashMap<>();
				Binome argument, retour;
				int i = 0;
				for (ExprContext exp : ctx.calling_fonction().expr() ) {
					argument = evaluate(exp);
					if (argument._1 == 0) { //evaluation reussie pour argument i
						map.put(procedure_called.getVariables().get(i++), argument._2);
					}
					else
						return argument._1;
				}
				
				vartab.getVariables().push(map);
				
				if (procedure_called.getList_instructions() != null)
					visit(procedure_called.getList_instructions());
				if(procedure_called.getRends() != null) {
					retour = evaluate(procedure_called.getRends());
					if(retour._1  == 0) //evaluation reussie pour la valeur de retour
						setExprValue(ctx, retour._2);
				}
				else {
					Log.appendnl("Erreur : la fonction "+ proc_name +" n'a pas de retour");
					return 0;
				}
				
				vartab.getVariables().pop();
			}
				
		}catch (NullPointerException ex) {ex.printStackTrace();}
				
		return 0;
	}


	@Override
	public Integer visitPour(PourContext ctx) {
		Log.appendnl("VisitPour");
		
		current_proc.setName(ctx.STRING().getText());
		
		if (ctx.liste_arguments() != null)
			visitListe_arguments(ctx.liste_arguments());
		
		if (ctx.liste_instructions() != null)
			current_proc.setList_instructions(ctx.liste_instructions());
		
		if (ctx.expr() != null)
			current_proc.setRends(ctx.expr());
		
		procedures.add(current_proc);
		current_proc = new LogoProcedure();
		//Log.appendnl("nb procedures =" + procedures.size());
		return 0;
	}

	@Override
	public Integer visitListe_arguments(Liste_argumentsContext ctx) {
		Log.appendnl("VisitListArgument");
			for (TerminalNode argument : ctx.STRING()){
				current_proc.getVariables().add(argument.getText());
				Log.appendnl("VisitArgument arg " + argument.getText());
			}
		return 0;
	}
	
	
	
}
