// Generated from Logo.g4 by ANTLR 4.4
		
  package logoparsing;

import org.antlr.v4.runtime.misc.NotNull;
import org.antlr.v4.runtime.tree.ParseTreeListener;

/**
 * This interface defines a complete listener for a parse tree produced by
 * {@link LogoParser}.
 */
public interface LogoListener extends ParseTreeListener {
	/**
	 * Enter a parse tree produced by the {@code bc}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterBc(@NotNull LogoParser.BcContext ctx);
	/**
	 * Exit a parse tree produced by the {@code bc}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitBc(@NotNull LogoParser.BcContext ctx);
	/**
	 * Enter a parse tree produced by the {@code mult}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void enterMult(@NotNull LogoParser.MultContext ctx);
	/**
	 * Exit a parse tree produced by the {@code mult}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void exitMult(@NotNull LogoParser.MultContext ctx);
	/**
	 * Enter a parse tree produced by the {@code bool}
	 * labeled alternative in {@link LogoParser#expr_bool}.
	 * @param ctx the parse tree
	 */
	void enterBool(@NotNull LogoParser.BoolContext ctx);
	/**
	 * Exit a parse tree produced by the {@code bool}
	 * labeled alternative in {@link LogoParser#expr_bool}.
	 * @param ctx the parse tree
	 */
	void exitBool(@NotNull LogoParser.BoolContext ctx);
	/**
	 * Enter a parse tree produced by the {@code cos}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void enterCos(@NotNull LogoParser.CosContext ctx);
	/**
	 * Exit a parse tree produced by the {@code cos}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void exitCos(@NotNull LogoParser.CosContext ctx);
	/**
	 * Enter a parse tree produced by the {@code fcc}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterFcc(@NotNull LogoParser.FccContext ctx);
	/**
	 * Exit a parse tree produced by the {@code fcc}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitFcc(@NotNull LogoParser.FccContext ctx);
	/**
	 * Enter a parse tree produced by the {@code parenthese}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void enterParenthese(@NotNull LogoParser.ParentheseContext ctx);
	/**
	 * Exit a parse tree produced by the {@code parenthese}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void exitParenthese(@NotNull LogoParser.ParentheseContext ctx);
	/**
	 * Enter a parse tree produced by the {@code sum}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void enterSum(@NotNull LogoParser.SumContext ctx);
	/**
	 * Exit a parse tree produced by the {@code sum}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void exitSum(@NotNull LogoParser.SumContext ctx);
	/**
	 * Enter a parse tree produced by the {@code while}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterWhile(@NotNull LogoParser.WhileContext ctx);
	/**
	 * Exit a parse tree produced by the {@code while}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitWhile(@NotNull LogoParser.WhileContext ctx);
	/**
	 * Enter a parse tree produced by {@link LogoParser#calling_fonction}.
	 * @param ctx the parse tree
	 */
	void enterCalling_fonction(@NotNull LogoParser.Calling_fonctionContext ctx);
	/**
	 * Exit a parse tree produced by {@link LogoParser#calling_fonction}.
	 * @param ctx the parse tree
	 */
	void exitCalling_fonction(@NotNull LogoParser.Calling_fonctionContext ctx);
	/**
	 * Enter a parse tree produced by the {@code float}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void enterFloat(@NotNull LogoParser.FloatContext ctx);
	/**
	 * Exit a parse tree produced by the {@code float}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void exitFloat(@NotNull LogoParser.FloatContext ctx);
	/**
	 * Enter a parse tree produced by the {@code operation_bool}
	 * labeled alternative in {@link LogoParser#expr_bool}.
	 * @param ctx the parse tree
	 */
	void enterOperation_bool(@NotNull LogoParser.Operation_boolContext ctx);
	/**
	 * Exit a parse tree produced by the {@code operation_bool}
	 * labeled alternative in {@link LogoParser#expr_bool}.
	 * @param ctx the parse tree
	 */
	void exitOperation_bool(@NotNull LogoParser.Operation_boolContext ctx);
	/**
	 * Enter a parse tree produced by the {@code donne}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterDonne(@NotNull LogoParser.DonneContext ctx);
	/**
	 * Exit a parse tree produced by the {@code donne}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitDonne(@NotNull LogoParser.DonneContext ctx);
	/**
	 * Enter a parse tree produced by {@link LogoParser#liste_procedure_def}.
	 * @param ctx the parse tree
	 */
	void enterListe_procedure_def(@NotNull LogoParser.Liste_procedure_defContext ctx);
	/**
	 * Exit a parse tree produced by {@link LogoParser#liste_procedure_def}.
	 * @param ctx the parse tree
	 */
	void exitListe_procedure_def(@NotNull LogoParser.Liste_procedure_defContext ctx);
	/**
	 * Enter a parse tree produced by the {@code repete}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterRepete(@NotNull LogoParser.RepeteContext ctx);
	/**
	 * Exit a parse tree produced by the {@code repete}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitRepete(@NotNull LogoParser.RepeteContext ctx);
	/**
	 * Enter a parse tree produced by {@link LogoParser#liste_arguments}.
	 * @param ctx the parse tree
	 */
	void enterListe_arguments(@NotNull LogoParser.Liste_argumentsContext ctx);
	/**
	 * Exit a parse tree produced by {@link LogoParser#liste_arguments}.
	 * @param ctx the parse tree
	 */
	void exitListe_arguments(@NotNull LogoParser.Liste_argumentsContext ctx);
	/**
	 * Enter a parse tree produced by the {@code loop}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void enterLoop(@NotNull LogoParser.LoopContext ctx);
	/**
	 * Exit a parse tree produced by the {@code loop}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void exitLoop(@NotNull LogoParser.LoopContext ctx);
	/**
	 * Enter a parse tree produced by the {@code sin}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void enterSin(@NotNull LogoParser.SinContext ctx);
	/**
	 * Exit a parse tree produced by the {@code sin}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void exitSin(@NotNull LogoParser.SinContext ctx);
	/**
	 * Enter a parse tree produced by {@link LogoParser#programme}.
	 * @param ctx the parse tree
	 */
	void enterProgramme(@NotNull LogoParser.ProgrammeContext ctx);
	/**
	 * Exit a parse tree produced by {@link LogoParser#programme}.
	 * @param ctx the parse tree
	 */
	void exitProgramme(@NotNull LogoParser.ProgrammeContext ctx);
	/**
	 * Enter a parse tree produced by the {@code if}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterIf(@NotNull LogoParser.IfContext ctx);
	/**
	 * Exit a parse tree produced by the {@code if}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitIf(@NotNull LogoParser.IfContext ctx);
	/**
	 * Enter a parse tree produced by the {@code fpos}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterFpos(@NotNull LogoParser.FposContext ctx);
	/**
	 * Exit a parse tree produced by the {@code fpos}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitFpos(@NotNull LogoParser.FposContext ctx);
	/**
	 * Enter a parse tree produced by the {@code move}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterMove(@NotNull LogoParser.MoveContext ctx);
	/**
	 * Exit a parse tree produced by the {@code move}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitMove(@NotNull LogoParser.MoveContext ctx);
	/**
	 * Enter a parse tree produced by the {@code pour}
	 * labeled alternative in {@link LogoParser#procedure_def}.
	 * @param ctx the parse tree
	 */
	void enterPour(@NotNull LogoParser.PourContext ctx);
	/**
	 * Exit a parse tree produced by the {@code pour}
	 * labeled alternative in {@link LogoParser#procedure_def}.
	 * @param ctx the parse tree
	 */
	void exitPour(@NotNull LogoParser.PourContext ctx);
	/**
	 * Enter a parse tree produced by the {@code store}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterStore(@NotNull LogoParser.StoreContext ctx);
	/**
	 * Exit a parse tree produced by the {@code store}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitStore(@NotNull LogoParser.StoreContext ctx);
	/**
	 * Enter a parse tree produced by the {@code procedure}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterProcedure(@NotNull LogoParser.ProcedureContext ctx);
	/**
	 * Exit a parse tree produced by the {@code procedure}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitProcedure(@NotNull LogoParser.ProcedureContext ctx);
	/**
	 * Enter a parse tree produced by the {@code ve}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterVe(@NotNull LogoParser.VeContext ctx);
	/**
	 * Exit a parse tree produced by the {@code ve}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitVe(@NotNull LogoParser.VeContext ctx);
	/**
	 * Enter a parse tree produced by the {@code td}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterTd(@NotNull LogoParser.TdContext ctx);
	/**
	 * Exit a parse tree produced by the {@code td}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitTd(@NotNull LogoParser.TdContext ctx);
	/**
	 * Enter a parse tree produced by {@link LogoParser#liste_instructions}.
	 * @param ctx the parse tree
	 */
	void enterListe_instructions(@NotNull LogoParser.Liste_instructionsContext ctx);
	/**
	 * Exit a parse tree produced by {@link LogoParser#liste_instructions}.
	 * @param ctx the parse tree
	 */
	void exitListe_instructions(@NotNull LogoParser.Liste_instructionsContext ctx);
	/**
	 * Enter a parse tree produced by the {@code tg}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterTg(@NotNull LogoParser.TgContext ctx);
	/**
	 * Exit a parse tree produced by the {@code tg}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitTg(@NotNull LogoParser.TgContext ctx);
	/**
	 * Enter a parse tree produced by the {@code re}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterRe(@NotNull LogoParser.ReContext ctx);
	/**
	 * Exit a parse tree produced by the {@code re}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitRe(@NotNull LogoParser.ReContext ctx);
	/**
	 * Enter a parse tree produced by the {@code av}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterAv(@NotNull LogoParser.AvContext ctx);
	/**
	 * Exit a parse tree produced by the {@code av}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitAv(@NotNull LogoParser.AvContext ctx);
	/**
	 * Enter a parse tree produced by the {@code lc}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void enterLc(@NotNull LogoParser.LcContext ctx);
	/**
	 * Exit a parse tree produced by the {@code lc}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 */
	void exitLc(@NotNull LogoParser.LcContext ctx);
	/**
	 * Enter a parse tree produced by the {@code variable}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void enterVariable(@NotNull LogoParser.VariableContext ctx);
	/**
	 * Exit a parse tree produced by the {@code variable}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void exitVariable(@NotNull LogoParser.VariableContext ctx);
	/**
	 * Enter a parse tree produced by the {@code fonction}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void enterFonction(@NotNull LogoParser.FonctionContext ctx);
	/**
	 * Exit a parse tree produced by the {@code fonction}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void exitFonction(@NotNull LogoParser.FonctionContext ctx);
	/**
	 * Enter a parse tree produced by the {@code hasard}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void enterHasard(@NotNull LogoParser.HasardContext ctx);
	/**
	 * Exit a parse tree produced by the {@code hasard}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 */
	void exitHasard(@NotNull LogoParser.HasardContext ctx);
	/**
	 * Enter a parse tree produced by {@link LogoParser#calling_procedure}.
	 * @param ctx the parse tree
	 */
	void enterCalling_procedure(@NotNull LogoParser.Calling_procedureContext ctx);
	/**
	 * Exit a parse tree produced by {@link LogoParser#calling_procedure}.
	 * @param ctx the parse tree
	 */
	void exitCalling_procedure(@NotNull LogoParser.Calling_procedureContext ctx);
}