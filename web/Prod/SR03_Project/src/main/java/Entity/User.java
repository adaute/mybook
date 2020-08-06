package Entity;

import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.validation.constraints.NotNull;
import javax.validation.constraints.Pattern;
import javax.validation.constraints.Size;
import java.io.Serializable;
import java.sql.Timestamp;
import java.text.SimpleDateFormat;

@Entity
public class User implements Serializable {

    // Attributs

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @NotNull(message = "Veuillez saisir une adresse email")
    @Pattern(regexp = "([^.@]+)(\\.[^.@]+)*@([^.@]+\\.)+([^.@]+)", message = "Merci de saisir une adresse mail valide")
    private String email;

    private String password;

    @NotNull(message = "Veuillez saisir un prénom")
    @Size(min = 3, message = "Le prénom doit contenir au moins 3 caractères")
    private String firstName;

    @NotNull(message = "Veuillez saisir un nom")
    @Size(min = 3, message = "Le nom doit contenir au moins 3 caractères")
    private String lastName;

    @NotNull(message = "Veuillez saisir un mot de passe")
    @Size(min = 3, message = "Le nom de la société doit contenir au moins 3 caractères")
    private String compagny;

    @NotNull(message = "Veuillez saisir un numéro de téléphone")
    @Pattern(regexp = "(([0-9]{2} ?){5})", message = "Merci de saisir un numéro de téléphone valide")
    private String phone;

    private Timestamp createdAt;
    private Boolean Status;
    private Integer statutUser; // 0:Stagiaire 1: Admin

    //Getters
    public Long getId() {
        return id;
    }

    //Setters
    public void setId(Long id) {
        this.id = id;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getFirstName() {
        return firstName;
    }

    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }

    public String getLastName() {
        return lastName;
    }

    public void setLastName(String lastName) {
        this.lastName = lastName;
    }

    public String getCompagny() {
        return compagny;
    }

    public void setCompagny(String compagny) {
        this.compagny = compagny;
    }

    public String getPhone() {
        return phone;
    }

    public void setPhone(String phone) {
        this.phone = phone;
    }

    public Timestamp getCreatedAt() {
        return createdAt;
    }

    public void setCreatedAt(Timestamp createdAt) {
        this.createdAt = createdAt;
    }

    public Boolean getStatus() {
        return Status;
    }

    public void setStatus(Boolean status) {
        Status = status;
    }

    public Integer getStatutUser() {
        return statutUser;
    }

    public void setStatutUser(Integer statutUser) {
        this.statutUser = statutUser;
    }

    @Override
    public String toString() {
        return "User{" +
                "id=" + id +
                ", email='" + email + '\'' +
                ", password='" + password + '\'' +
                ", firstName='" + firstName + '\'' +
                ", lastName='" + lastName + '\'' +
                ", compagny='" + compagny + '\'' +
                ", phone='" + phone + '\'' +
                ", createdAt=" + createdAt +
                ", Status=" + Status +
                ", statutUser=" + statutUser +
                '}';
    }

    public String dateFormat() {
        return new SimpleDateFormat("dd MMM yyyy").format(this.createdAt);
    }
}
