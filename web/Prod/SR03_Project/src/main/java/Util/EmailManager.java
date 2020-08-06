package Util;

import javax.mail.Message;
import javax.mail.MessagingException;
import javax.mail.Session;
import javax.mail.Transport;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeBodyPart;
import javax.mail.internet.MimeMessage;
import javax.mail.internet.MimeMultipart;
import java.util.Date;
import java.util.Properties;

/**
 * Cette classe permet d'envoyer un email
 */

public class EmailManager {
    private final static String MAILER_VERSION = "Java";

    public static void envoyer(String mail, String content, boolean debug) {

        InternetAddress[] internetAddresses = new InternetAddress[1];

        Properties prop = System.getProperties();
        prop.put("mail.smtp.host", "smtp1.utc.fr");
        prop.put("mail.smtp.port", "25");
        Session session = Session.getDefaultInstance(prop, null);

        Message message = new MimeMessage(session);

        try {
            internetAddresses[0] = new InternetAddress(mail);

            message.setFrom(new InternetAddress("noreply@utc.fr"));
            message.setRecipients(Message.RecipientType.TO, internetAddresses);

            MimeBodyPart textBodyPart = new MimeBodyPart();
            textBodyPart.setText(content);

            MimeMultipart mimeMultipart = new MimeMultipart();
            mimeMultipart.addBodyPart(textBodyPart);

            message.setContent(mimeMultipart);
            message.setSubject("Plateforme Projet_SR03");
            message.setHeader("X-Mailer", MAILER_VERSION);
            message.setSentDate(new Date());
            Transport.send(message);
        } catch (MessagingException e) {
            System.out.println(e);
        }
    }
}

