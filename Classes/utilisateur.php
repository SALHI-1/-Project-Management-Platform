<?php

class utilisateur {

private $nom;
private $prenom;
private $email;
private $mdp;

private $role;

private $pdo; // Connexion à la base de données

function __construct($pdo, $nom='', $prenom='', $email='', $role='') {

    $this->nom=$nom;

    $this->prenom=$prenom;

    $this->email=$email;
    
    $this->pdo = $pdo; // Injection de dépendance pour PDO
    
    $this->role = $role;
}
//GETTERS
function getNom(){
    return $this->nom;
}
function getPrenom(){
    return $this->prenom;
}
function getEmail(){
    return $this->email;
}
function getRole() {
    return $this->role;
}
//SETTERS

function setNom($nom){

    $this->nom=$nom;
}
       
function setPrenom($prenom){

    $this->prenom=$prenom;
}

function setEmail($email){

    $this->email=$email;
}

function setPwd($mdp){

    $this->mdp=$mdp;
}

function setRole($role){

    $this->role=$role;
}



//methode d'insertion
public function insert() {
  
    $query = "INSERT INTO utilisateur (nom, prenom, email, mdp, role) VALUES (:nom, :prenom, :email, :password, :role)";
    $stmt = $this->pdo->prepare($query);

    // Nettoyage des données
    $nom = htmlspecialchars(strip_tags($this->nom));
    $prenom = htmlspecialchars(strip_tags($this->prenom));
    $email = htmlspecialchars(strip_tags($this->email));
    $password = password_hash($this->mdp, PASSWORD_BCRYPT); // Hachage du mot de passe
    $role = htmlspecialchars(strip_tags($this->role));

    // Bind des paramètres
    $stmt->bindParam(":nom", $nom);
    $stmt->bindParam(":prenom", $prenom);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $password);
    $stmt->bindParam(":role", $role);

    // Exécution de la requête
    if ($stmt->execute()) {
        return true;
    }
    return false;
}


public function updateUser_with_mdp($id) {
    $password = password_hash($this->mdp, PASSWORD_BCRYPT); // Hachage du mot de passe
        $sql = "UPDATE utilisateur SET nom = :nom, prenom = :prenom, email = :email,mdp = :mdp ,role = :role WHERE id = :id";
        $stm = $this->pdo->prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->bindParam(':nom', $this->nom);
        $stm->bindParam(':prenom', $this->prenom);
        $stm->bindParam(':email', $this->email);
        $stm->bindParam(':mdp', $password);
        $stm->bindParam(':role', $this->role);

        if ($stm->execute()) {
            return true;
        }
        return false;
}

public function updateUser_no_mdp($id) {
    $sql = "UPDATE utilisateur SET nom = :nom, prenom = :prenom, email = :email,role = :role WHERE id = :id";
    $stm = $this->pdo->prepare($sql);
    $stm->bindParam(':id', $id, PDO::PARAM_INT);
    $stm->bindParam(':nom', $this->nom);
    $stm->bindParam(':prenom', $this->prenom);
    $stm->bindParam(':email', $this->email);
    $stm->bindParam(':role', $this->role);
    $stm->execute();

    if ($stm->execute()) {
        return true;
    }
    return false;
}

public function updateProfile_with_mdp($id) {
    $password = password_hash($this->mdp, PASSWORD_BCRYPT); // Hachage du mot de passe

    $sql = "UPDATE utilisateur SET nom = :nom, prenom = :prenom, email = :email, mdp = :mdp WHERE id = :id";
    $stm = $this->pdo->prepare($sql);
    $stm->bindParam(':id', $id, PDO::PARAM_INT);
    $stm->bindParam(':nom', $this->nom);
    $stm->bindParam(':prenom', $this->prenom);
    $stm->bindParam(':email', $this->email);
    $stm->bindParam(':mdp', $password);

    $stm->execute();

    if ($stm->execute()) {
        return true;
    }
    return false;
}

public function updateProfile_no_mdp($id) {
    $sql = "UPDATE utilisateur SET nom = :nom, prenom = :prenom, email = :email WHERE id = :id";
    $stm = $this->pdo->prepare($sql);
    $stm->bindParam(':id', $id, PDO::PARAM_INT);
    $stm->bindParam(':nom', $this->nom);
    $stm->bindParam(':prenom', $this->prenom);
    $stm->bindParam(':email', $this->email);
    $stm->execute();

    if ($stm->execute()) {
        return true;
    }
    return false;
}

public function delet_user($id) {
   

    $stmt = $this->pdo->prepare("DELETE FROM utilisateur WHERE id = ?");
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        return true ;
    } else {
        return false ;
    }
}


}












?>