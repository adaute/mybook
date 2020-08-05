package logogui;

import java.util.HashMap;
import java.util.Map;
import java.util.Stack;

public class LogoVar {	
	private Stack<Map<String, Double>> variables = new Stack<>();
	
	public LogoVar() {
		Map<String, Double> main_variables = new HashMap<>();
		this.variables.push(main_variables);
	}
	
	public Stack<Map<String, Double>> getVariables() {
		return variables;
	}

	public void setVariables(Stack<Map<String, Double>> variables) {
		this.variables = variables;
	}
	
}
