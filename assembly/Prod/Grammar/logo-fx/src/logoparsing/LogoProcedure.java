package logoparsing;

import java.util.ArrayList;

import logoparsing.LogoParser.ExprContext;
import logoparsing.LogoParser.Liste_instructionsContext;

public class LogoProcedure {
	private String name;
	private ArrayList<String> variables = new ArrayList<>();
	private Liste_instructionsContext list_instructions = null;
	private ExprContext rends = null;
	
	public String getName() {
		return name;
	}
	
	public void setName(String name) {
		this.name = name;
	}
	
	public ArrayList<String> getVariables() {
		return variables;
	}
	
	public void setVariables(ArrayList<String> variables) {
		this.variables = variables;
	}

	
	public Liste_instructionsContext getList_instructions() {
		return list_instructions;
	}
	
	public void setList_instructions(Liste_instructionsContext list_instructions) {
		this.list_instructions = list_instructions;
	}

	public ExprContext getRends() {
		return rends;
	}

	public void setRends(ExprContext rends) {
		this.rends = rends;
	}
	
	
	
}
