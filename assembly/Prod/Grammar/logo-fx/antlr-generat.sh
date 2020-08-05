export SAVECLASSPATH=$CLASSPATH
export CLASSPATH=lib/antlr-4.7.1-complete.jar;
java org.antlr.v4.Tool -visitor -o src/logoparsing grammar/Logo.g4
export CLASSPATH=$SAVECLASSPATH
