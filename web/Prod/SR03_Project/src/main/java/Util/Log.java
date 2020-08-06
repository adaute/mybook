package Util;

import java.io.File;
import java.io.FileWriter;
import java.io.IOException;

/**
 * Cette classe permet de générer des logs de débogage.
 */

public class Log {
    /*
        Dans les action, on ne peut pas appeler System.out.println. On passe donc par cette casse qui affichera les logs
        dans racine/log/log.log
     */
    private static final String path = "";

    public void log(String to_write) {
        try {
            File yourFile = new File(path);
            yourFile.createNewFile(); // if file already exists will do nothing
            FileWriter fw = new FileWriter(path, true); //the true will append the new data
            fw.write(to_write);//appends the string to the file
            fw.write("\n");
            fw.close();
        } catch (IOException e) {
            System.out.print("ERROR : ");
            System.out.println(e.getMessage());
        }
    }
}
