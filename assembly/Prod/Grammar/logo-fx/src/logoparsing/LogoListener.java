// Generated from grammar/Logo.g4 by ANTLR 4.7.1
		
  package logoparsing;

import org.antlr.v4.runtime.tree.ParseTreeListener;

/**
 * This interface defines a complete listener for a parse tree produced by
 * {@link LogoParser}.
 */
public interface LogoListener extends ParseTreeListener {
	/**
	 * Enter a parse tree produced by {@link LogoParser#programme}.
	 * @param ctx the parse tree
	 */
	void enterProgramme(LogoParser.ProgrammeContext ctx);
	/**
	 * Exit a parse tree produced by {@link LogoParser#programme}.
	 * @param ctx the parse tree
	 */
	void exitProgramme(LogoParser.ProgrammeContext ctx);
	/**
	 * Enter a parse tree produced by {@link LogoParser#liste_instructions}.
	 * @param ctx the parse tree
	 */
	void enterListe_instructions(LogoParser.Liste_instructionsContext ctx);
	/**
	 * Exit a parse tree produced by {@link LogoParser#liste_instructions}.
	 * @param ctx the parse tree
	 */
	void exitListe_instructions(LogoParser.Liste_instructionsContext ctx);
	/**
	 * Enter a parse tree produced by the {@code av}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterAv(LogoParser.AvContext ctx);
	/**
	 * Exit a parse tree produced by the {@code av}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitAv(LogoParser.AvContext ctx);
	/**
	 * Enter a parse tree produced by the {@code td}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterTd(LogoParser.TdContext ctx);
	/**
	 * Exit a parse tree produced by the {@code td}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitTd(LogoParser.TdContext ctx);
	/**
	 * Enter a parse tree produced by the {@code tg}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterTg(LogoParser.TgContext ctx);
	/**
	 * Exit a parse tree produced by the {@code tg}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitTg(LogoParser.TgContext ctx);
	/**
	 * Enter a parse tree produced by the {@code lc}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterLc(LogoParser.LcContext ctx);
	/**
	 * Exit a parse tree produced by the {@code lc}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitLc(LogoParser.LcContext ctx);
	/**
	 * Enter a parse tree produced by the {@code bc}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterBc(LogoParser.BcContext ctx);
	/**
	 * Exit a parse tree produced by the {@code bc}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitBc(LogoParser.BcContext ctx);
	/**
	 * Enter a parse tree produced by the {@code ve}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterVe(LogoParser.VeContext ctx);
	/**
	 * Exit a parse tree produced by the {@code ve}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitVe(LogoParser.VeContext ctx);
	/**
	 * Enter a parse tree produced by the {@code re}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterRe(LogoParser.ReContext ctx);
	/**
	 * Exit a parse tree produced by the {@code re}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitRe(LogoParser.ReContext ctx);
	/**
	 * Enter a parse tree produced by the {@code fpos}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterFpos(LogoParser.FposContext ctx);
	/**
	 * Exit a parse tree produced by the {@code fpos}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitFpos(LogoParser.FposContext ctx);
	/**
	 * Enter a parse tree produced by the {@code fcc}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterFcc(LogoParser.FccContext ctx);
	/**
	 * Exit a parse tree produced by the {@code fcc}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitFcc(LogoParser.FccContext ctx);
	/**
	 * Enter a parse tree produced by the {@code repete}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterRepete(LogoParser.RepeteContext ctx);
	/**
	 * Exit a parse tree produced by the {@code repete}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitRepete(LogoParser.RepeteContext ctx);
	/**
	 * Enter a parse tree produced by the {@code store}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterStore(LogoParser.StoreContext ctx);
	/**
	 * Exit a parse tree produced by the {@code store}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitStore(LogoParser.StoreContext ctx);
	/**
	 * Enter a parse tree produced by the {@code move}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterMove(LogoParser.MoveContext ctx);
	/**
	 * Exit a parse tree produced by the {@code move}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitMove(LogoParser.MoveContext ctx);
	/**
	 * Enter a parse tree produced by the {@code donne}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterDonne(LogoParser.DonneContext ctx);
	/**
	 * Exit a parse tree produced by the {@code donne}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitDonne(LogoParser.DonneContext ctx);
	/**
	 * Enter a parse tree produced by the {@code if}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterIf(LogoParser.IfContext ctx);
	/**
	 * Exit a parse tree produced by the {@code if}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitIf(LogoParser.IfContext ctx);
	/**
	 * Enter a parse tree produced by the {@code while}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterWhile(LogoParser.WhileContext ctx);
	/**
	 * Exit a parse tree produced by the {@code while}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitWhile(LogoParser.WhileContext ctx);
	/**
	 * Enter a parse tree produced by the {@code procedure}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterProcedure(LogoParser.ProcedureContext ctx);
	/**
	 * Exit a parse tree produced by the {@code procedure}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitProcedure(LogoParser.ProcedureContext ctx);
	/**
	 * Enter a parse tree produced by {@link LogoParser#liste_procedure_def}.
	 * @param ctx the parse tree
	 */
	void enterListe_procedure_def(LogoParser.Liste_procedure_defContext ctx);
	/**
	 * Exit a parse tree produced by {@link LogoParser#liste_procedure_def}.
	 * @param ctx the parse tree
	 */
	void exitListe_procedure_def(LogoParser.Liste_procedure_defContext ctx);
	/**
	 * Enter a parse tree produced by the {@code pour}
	 * labeled alternative in {@link LogoParser#procedure_def}.
	 * @param ctx the parse tree
	 */
	void enterPour(LogoParser.PourContext ctx);
	/**
	 * Exit a parse tree produced by the {@code pour}
	 * labeled alternative in {@link LogoParser#procedure_def}.
	 * @param ctx the parse tree
	 */
	void exitPour(LogoParser.PourContext ctx);
	/**
	 * Enter a parse tree produced by {@link LogoParser#calling_procedure}.
	 * @param ctx the parse tree
	 */
	void enterCalling_procedure(LogoParser.Calling_procedureContext ctx);
	/**
	 * Exit a parse tree produced by {@link LogoParser#calling_procedure}.
	 * @param ctx the parse tree
	 */
	void exitCalling_procedure(LogoParser.Calling_procedureContext ctx);
	/**
	 * Enter a parse tree produced by {@link LogoParser#calling_fonction}.
	 * @param ctx the parse tree
	 */
	void enterCalling_fonction(LogoParser.Calling_fonctionContext ctx);
	/**
	 * Exit a parse tree produced by {@link LogoParser#calling_fonction}.
	 * @param ctx the parse tree
	 */
	void exitCalling_fonction(LogoParser.Calling_fonctionContext ctx);
	/**
	 * Enter a parse tree produced by the {@code mult}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void enterMult(LogoParser.MultContext ctx);
	/**
	 * Exit a parse tree produced by the {@code mult}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void exitMult(LogoParser.MultContext ctx);
	/**
	 * Enter a parse tree produced by the {@code cos}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void enterCos(LogoParser.CosContext ctx);
	/**
	 * Exit a parse tree produced by the {@code cos}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void exitCos(LogoParser.CosContext ctx);
	/**
	 * Enter a parse tree produced by the {@code loop}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void enterLoop(LogoParser.LoopContext ctx);
	/**
	 * Exit a parse tree produced by the {@code loop}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void exitLoop(LogoParser.LoopContext ctx);
	/**
	 * Enter a parse tree produced by the {@code variable}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void enterVariable(LogoParser.VariableContext ctx);
	/**
	 * Exit a parse tree produced by the {@code variable}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void exitVariable(LogoParser.VariableContext ctx);
	/**
	 * Enter a parse tree produced by the {@code fonction}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void enterFonction(LogoParser.FonctionContext ctx);
	/**
	 * Exit a parse tree produced by the {@code fonction}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void exitFonction(LogoParser.FonctionContext ctx);
	/**
	 * Enter a parse tree produced by the {@code sin}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void enterSin(LogoParser.SinContext ctx);
	/**
	 * Exit a parse tree produced by the {@code sin}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void exitSin(LogoParser.SinContext ctx);
	/**
	 * Enter a parse tree produced by the {@code parenthese}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void enterParenthese(LogoParser.ParentheseContext ctx);
	/**
	 * Exit a parse tree produced by the {@code parenthese}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void exitParenthese(LogoParser.ParentheseContext ctx);
	/**
	 * Enter a parse tree produced by the {@code sum}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void enterSum(LogoParser.SumContext ctx);
	/**
	 * Exit a parse tree produced by the {@code sum}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void exitSum(LogoParser.SumContext ctx);
	/**
	 * Enter a parse tree produced by the {@code float}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void enterFloat(LogoParser.FloatContext ctx);
	/**
	 * Exit a parse tree produced by the {@code float}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void exitFloat(LogoParser.FloatContext ctx);
	/**
	 * Enter a parse tree produced by the {@code hasard}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void enterHasard(LogoParser.HasardContext ctx);
	/**
	 * Exit a parse tree produced by the {@code hasard}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void exitHasard(LogoParser.HasardContext ctx);
	/**
	 * Enter a parse tree produced by the {@code bool}
	 * labeled alternative in {@link LogoParser#expr_bool}.
	 * @param ctx the parse tree
	 */
	void enterBool(LogoParser.BoolContext ctx);
	/**
	 * Exit a parse tree produced by the {@code bool}
	 * labeled alternative in {@link LogoParser#expr_bool}.
	 * @param ctx the parse tree
	 */
	void exitBool(LogoParser.BoolContext ctx);
	/**
	 * Enter a parse tree produced by the {@code operation_bool}
	 * labeled alternative in {@link LogoParser#expr_bool}.
	 * @param ctx the parse tree
	 */
	void enterOperation_bool(LogoParser.Operation_boolContext ctx);
	/**
	 * Exit a parse tree produced by the {@code operation_bool}
	 * labeled alternative in {@link LogoParser#expr_bool}.
	 * @param ctx the parse tree
	 */
	void exitOperation_bool(LogoParser.Operation_boolContext ctx);
	/**
	 * Enter a parse tree produced by {@link LogoParser#liste_arguments}.
	 * @param ctx the parse tree
	 */
	void enterListe_arguments(LogoParser.Liste_argumentsContext ctx);
	/**
	 * Exit a parse tree produced by {@link LogoParser#liste_arguments}.
	 * @param ctx the parse tree
	 */
	void exitListe_arguments(LogoParser.Liste_argumentsContext ctx);
}