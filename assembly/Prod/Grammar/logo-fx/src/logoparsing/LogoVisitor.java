// Generated from grammar/Logo.g4 by ANTLR 4.7.1
		
  package logoparsing;

import org.antlr.v4.runtime.tree.ParseTreeVisitor;

/**
 * This interface defines a complete generic visitor for a parse tree produced
 * by {@link LogoParser}.
 *
 * @param <T> The return type of the visit operation. Use {@link Void} for
 * operations with no return type.
 */
public interface LogoVisitor<T> extends ParseTreeVisitor<T> {
	/**
	 * Visit a parse tree produced by {@link LogoParser#programme}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitProgramme(LogoParser.ProgrammeContext ctx);
	/**
	 * Visit a parse tree produced by {@link LogoParser#liste_instructions}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitListe_instructions(LogoParser.Liste_instructionsContext ctx);
	/**
	 * Visit a parse tree produced by the {@code av}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitAv(LogoParser.AvContext ctx);
	/**
	 * Visit a parse tree produced by the {@code td}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitTd(LogoParser.TdContext ctx);
	/**
	 * Visit a parse tree produced by the {@code tg}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitTg(LogoParser.TgContext ctx);
	/**
	 * Visit a parse tree produced by the {@code lc}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitLc(LogoParser.LcContext ctx);
	/**
	 * Visit a parse tree produced by the {@code bc}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitBc(LogoParser.BcContext ctx);
	/**
	 * Visit a parse tree produced by the {@code ve}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitVe(LogoParser.VeContext ctx);
	/**
	 * Visit a parse tree produced by the {@code re}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitRe(LogoParser.ReContext ctx);
	/**
	 * Visit a parse tree produced by the {@code fpos}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitFpos(LogoParser.FposContext ctx);
	/**
	 * Visit a parse tree produced by the {@code fcc}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitFcc(LogoParser.FccContext ctx);
	/**
	 * Visit a parse tree produced by the {@code repete}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitRepete(LogoParser.RepeteContext ctx);
	/**
	 * Visit a parse tree produced by the {@code store}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitStore(LogoParser.StoreContext ctx);
	/**
	 * Visit a parse tree produced by the {@code move}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitMove(LogoParser.MoveContext ctx);
	/**
	 * Visit a parse tree produced by the {@code donne}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitDonne(LogoParser.DonneContext ctx);
	/**
	 * Visit a parse tree produced by the {@code if}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitIf(LogoParser.IfContext ctx);
	/**
	 * Visit a parse tree produced by the {@code while}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitWhile(LogoParser.WhileContext ctx);
	/**
	 * Visit a parse tree produced by the {@code procedure}
	 * labeled alternative in {@link LogoParser#instruction}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitProcedure(LogoParser.ProcedureContext ctx);
	/**
	 * Visit a parse tree produced by {@link LogoParser#liste_procedure_def}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitListe_procedure_def(LogoParser.Liste_procedure_defContext ctx);
	/**
	 * Visit a parse tree produced by the {@code pour}
	 * labeled alternative in {@link LogoParser#procedure_def}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitPour(LogoParser.PourContext ctx);
	/**
	 * Visit a parse tree produced by {@link LogoParser#calling_procedure}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitCalling_procedure(LogoParser.Calling_procedureContext ctx);
	/**
	 * Visit a parse tree produced by {@link LogoParser#calling_fonction}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitCalling_fonction(LogoParser.Calling_fonctionContext ctx);
	/**
	 * Visit a parse tree produced by the {@code mult}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitMult(LogoParser.MultContext ctx);
	/**
	 * Visit a parse tree produced by the {@code cos}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitCos(LogoParser.CosContext ctx);
	/**
	 * Visit a parse tree produced by the {@code loop}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitLoop(LogoParser.LoopContext ctx);
	/**
	 * Visit a parse tree produced by the {@code variable}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitVariable(LogoParser.VariableContext ctx);
	/**
	 * Visit a parse tree produced by the {@code fonction}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitFonction(LogoParser.FonctionContext ctx);
	/**
	 * Visit a parse tree produced by the {@code sin}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitSin(LogoParser.SinContext ctx);
	/**
	 * Visit a parse tree produced by the {@code parenthese}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitParenthese(LogoParser.ParentheseContext ctx);
	/**
	 * Visit a parse tree produced by the {@code sum}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitSum(LogoParser.SumContext ctx);
	/**
	 * Visit a parse tree produced by the {@code float}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitFloat(LogoParser.FloatContext ctx);
	/**
	 * Visit a parse tree produced by the {@code hasard}
	 * labeled alternative in {@link LogoParser#expr}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitHasard(LogoParser.HasardContext ctx);
	/**
	 * Visit a parse tree produced by the {@code bool}
	 * labeled alternative in {@link LogoParser#expr_bool}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitBool(LogoParser.BoolContext ctx);
	/**
	 * Visit a parse tree produced by the {@code operation_bool}
	 * labeled alternative in {@link LogoParser#expr_bool}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitOperation_bool(LogoParser.Operation_boolContext ctx);
	/**
	 * Visit a parse tree produced by {@link LogoParser#liste_arguments}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitListe_arguments(LogoParser.Liste_argumentsContext ctx);
}