// Generated from grammar/Logo.g4 by ANTLR 4.7.1
		
  package logoparsing;

import org.antlr.v4.runtime.Lexer;
import org.antlr.v4.runtime.CharStream;
import org.antlr.v4.runtime.Token;
import org.antlr.v4.runtime.TokenStream;
import org.antlr.v4.runtime.*;
import org.antlr.v4.runtime.atn.*;
import org.antlr.v4.runtime.dfa.DFA;
import org.antlr.v4.runtime.misc.*;

@SuppressWarnings({"all", "warnings", "unchecked", "unused", "cast"})
public class LogoLexer extends Lexer {
	static { RuntimeMetaData.checkVersion("4.7.1", RuntimeMetaData.VERSION); }

	protected static final DFA[] _decisionToDFA;
	protected static final PredictionContextCache _sharedContextCache =
		new PredictionContextCache();
	public static final int
		T__0=1, T__1=2, T__2=3, T__3=4, T__4=5, T__5=6, T__6=7, T__7=8, T__8=9, 
		T__9=10, T__10=11, T__11=12, T__12=13, T__13=14, T__14=15, FLOAT=16, STRING=17, 
		WS=18;
	public static String[] channelNames = {
		"DEFAULT_TOKEN_CHANNEL", "HIDDEN"
	};

	public static String[] modeNames = {
		"DEFAULT_MODE"
	};

	public static final String[] ruleNames = {
		"T__0", "T__1", "T__2", "T__3", "T__4", "T__5", "T__6", "T__7", "T__8", 
		"T__9", "T__10", "T__11", "T__12", "T__13", "T__14", "FLOAT", "STRING", 
		"WS"
	};

	private static final String[] _LITERAL_NAMES = {
		null, "'av'", "'td'", "'tg'", "'lc'", "'bc'", "'ve'", "'re'", "'fpos'", 
		"'fcc'", "'('", "')'", "'*'", "'/'", "'+'", "'-'"
	};
	private static final String[] _SYMBOLIC_NAMES = {
		null, null, null, null, null, null, null, null, null, null, null, null, 
		null, null, null, null, "FLOAT", "STRING", "WS"
	};
	public static final Vocabulary VOCABULARY = new VocabularyImpl(_LITERAL_NAMES, _SYMBOLIC_NAMES);

	/**
	 * @deprecated Use {@link #VOCABULARY} instead.
	 */
	@Deprecated
	public static final String[] tokenNames;
	static {
		tokenNames = new String[_SYMBOLIC_NAMES.length];
		for (int i = 0; i < tokenNames.length; i++) {
			tokenNames[i] = VOCABULARY.getLiteralName(i);
			if (tokenNames[i] == null) {
				tokenNames[i] = VOCABULARY.getSymbolicName(i);
			}

			if (tokenNames[i] == null) {
				tokenNames[i] = "<INVALID>";
			}
		}
	}

	@Override
	@Deprecated
	public String[] getTokenNames() {
		return tokenNames;
	}

	@Override

	public Vocabulary getVocabulary() {
		return VOCABULARY;
	}


	public LogoLexer(CharStream input) {
		super(input);
		_interp = new LexerATNSimulator(this,_ATN,_decisionToDFA,_sharedContextCache);
	}

	@Override
	public String getGrammarFileName() { return "Logo.g4"; }

	@Override
	public String[] getRuleNames() { return ruleNames; }

	@Override
	public String getSerializedATN() { return _serializedATN; }

	@Override
	public String[] getChannelNames() { return channelNames; }

	@Override
	public String[] getModeNames() { return modeNames; }

	@Override
	public ATN getATN() { return _ATN; }

	public static final String _serializedATN =
		"\3\u608b\ua72a\u8133\ub9ed\u417c\u3be7\u7786\u5964\2\24l\b\1\4\2\t\2\4"+
		"\3\t\3\4\4\t\4\4\5\t\5\4\6\t\6\4\7\t\7\4\b\t\b\4\t\t\t\4\n\t\n\4\13\t"+
		"\13\4\f\t\f\4\r\t\r\4\16\t\16\4\17\t\17\4\20\t\20\4\21\t\21\4\22\t\22"+
		"\4\23\t\23\3\2\3\2\3\2\3\3\3\3\3\3\3\4\3\4\3\4\3\5\3\5\3\5\3\6\3\6\3\6"+
		"\3\7\3\7\3\7\3\b\3\b\3\b\3\t\3\t\3\t\3\t\3\t\3\n\3\n\3\n\3\n\3\13\3\13"+
		"\3\f\3\f\3\r\3\r\3\16\3\16\3\17\3\17\3\20\3\20\3\21\3\21\7\21T\n\21\f"+
		"\21\16\21W\13\21\3\21\3\21\6\21[\n\21\r\21\16\21\\\5\21_\n\21\3\22\6\22"+
		"b\n\22\r\22\16\22c\3\23\6\23g\n\23\r\23\16\23h\3\23\3\23\2\2\24\3\3\5"+
		"\4\7\5\t\6\13\7\r\b\17\t\21\n\23\13\25\f\27\r\31\16\33\17\35\20\37\21"+
		"!\22#\23%\24\3\2\5\3\2\62;\4\2C\\c|\5\2\13\f\17\17\"\"\2p\2\3\3\2\2\2"+
		"\2\5\3\2\2\2\2\7\3\2\2\2\2\t\3\2\2\2\2\13\3\2\2\2\2\r\3\2\2\2\2\17\3\2"+
		"\2\2\2\21\3\2\2\2\2\23\3\2\2\2\2\25\3\2\2\2\2\27\3\2\2\2\2\31\3\2\2\2"+
		"\2\33\3\2\2\2\2\35\3\2\2\2\2\37\3\2\2\2\2!\3\2\2\2\2#\3\2\2\2\2%\3\2\2"+
		"\2\3\'\3\2\2\2\5*\3\2\2\2\7-\3\2\2\2\t\60\3\2\2\2\13\63\3\2\2\2\r\66\3"+
		"\2\2\2\179\3\2\2\2\21<\3\2\2\2\23A\3\2\2\2\25E\3\2\2\2\27G\3\2\2\2\31"+
		"I\3\2\2\2\33K\3\2\2\2\35M\3\2\2\2\37O\3\2\2\2!Q\3\2\2\2#a\3\2\2\2%f\3"+
		"\2\2\2\'(\7c\2\2()\7x\2\2)\4\3\2\2\2*+\7v\2\2+,\7f\2\2,\6\3\2\2\2-.\7"+
		"v\2\2./\7i\2\2/\b\3\2\2\2\60\61\7n\2\2\61\62\7e\2\2\62\n\3\2\2\2\63\64"+
		"\7d\2\2\64\65\7e\2\2\65\f\3\2\2\2\66\67\7x\2\2\678\7g\2\28\16\3\2\2\2"+
		"9:\7t\2\2:;\7g\2\2;\20\3\2\2\2<=\7h\2\2=>\7r\2\2>?\7q\2\2?@\7u\2\2@\22"+
		"\3\2\2\2AB\7h\2\2BC\7e\2\2CD\7e\2\2D\24\3\2\2\2EF\7*\2\2F\26\3\2\2\2G"+
		"H\7+\2\2H\30\3\2\2\2IJ\7,\2\2J\32\3\2\2\2KL\7\61\2\2L\34\3\2\2\2MN\7-"+
		"\2\2N\36\3\2\2\2OP\7/\2\2P \3\2\2\2QU\t\2\2\2RT\t\2\2\2SR\3\2\2\2TW\3"+
		"\2\2\2US\3\2\2\2UV\3\2\2\2V^\3\2\2\2WU\3\2\2\2XZ\7\60\2\2Y[\t\2\2\2ZY"+
		"\3\2\2\2[\\\3\2\2\2\\Z\3\2\2\2\\]\3\2\2\2]_\3\2\2\2^X\3\2\2\2^_\3\2\2"+
		"\2_\"\3\2\2\2`b\t\3\2\2a`\3\2\2\2bc\3\2\2\2ca\3\2\2\2cd\3\2\2\2d$\3\2"+
		"\2\2eg\t\4\2\2fe\3\2\2\2gh\3\2\2\2hf\3\2\2\2hi\3\2\2\2ij\3\2\2\2jk\b\23"+
		"\2\2k&\3\2\2\2\b\2U\\^ch\3\b\2\2";
	public static final ATN _ATN =
		new ATNDeserializer().deserialize(_serializedATN.toCharArray());
	static {
		_decisionToDFA = new DFA[_ATN.getNumberOfDecisions()];
		for (int i = 0; i < _ATN.getNumberOfDecisions(); i++) {
			_decisionToDFA[i] = new DFA(_ATN.getDecisionState(i), i);
		}
	}
}