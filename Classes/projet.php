<?php

class projet {

private $nom;
private $description;
private $date_debut;
private $date_fin_prevue;
private $statut;

private $id_resp;

private $pdo; // Connexion à la base de données

function __construct($pdo, $nom='' ,$description='', $date_debut='', $date_fin_prevue	='', $statut='',$id_resp='') {

    $this->nom=$nom;

    $this->description=$description;

    $this->date_debut=$date_debut;
    
    $this->pdo = $pdo; // Injection de dépendance pour PDO
    
    $this->date_fin_prevue	 = $date_fin_prevue	;

    $this->statut=$statut;

    $this->id_resp=$id_resp;

}
// Getters
public function getNom() {
    return $this->nom;
}

public function getDescription() {
    return $this->description;
}

public function getDateDebut() {
    return $this->date_debut;
}



public function getDateFin() {
    return $this->date_fin_prevue	;
}

public function getStatut() {
    return $this->statut;
}

public function getIdResp() {
    return $this->id_resp;
}

// Setters
public function setNom($nom) {
    $this->nom = $nom;
}

public function setDescription($description) {
    $this->description = $description;
}

public function setDateDebut($date_debut) {
    $this->date_debut = $date_debut;
}


public function setDateFin($date_fin) {
    $this->date_fin_prevue	 = $date_fin;
}

public function setStatut($statut) {
    $this->statut = $statut;
}

public function setIdResp($id_resp) {
    $this->id_resp = $id_resp;
}




//methode d'insertion
public function insert() {
    $query = "INSERT INTO projet (nom, description, date_debut, date_fin_prevue, statut, id_resp) 
              VALUES (:nom, :description, :date_debut, :date_fin_prevue, :statut, :id_resp)";
    $stmt = $this->pdo->prepare($query);

    // Nettoyage des données
    $nom = htmlspecialchars(strip_tags($this->nom));
    $description = htmlspecialchars(strip_tags($this->description));
    $date_debut = htmlspecialchars(strip_tags($this->date_debut));
    $date_fin_prevue = htmlspecialchars(strip_tags($this->date_fin_prevue));
    $statut = htmlspecialchars(strip_tags($this->statut));
    $id_resp = htmlspecialchars(strip_tags($this->id_resp));

    // Bind des paramètres
    $stmt->bindParam(":nom", $nom);
    $stmt->bindParam(":description", $description);
    $stmt->bindParam(":date_debut", $date_debut);
    $stmt->bindParam(":date_fin_prevue", $date_fin_prevue); // Supprimer l'espace/tabs
    $stmt->bindParam(":statut", $statut);
    $stmt->bindParam(":id_resp", $id_resp);

    // Exécution de la requête
    if ($stmt->execute()) {
        return true;
    }
    return false;
}




public function updateProjet($id) {
    $sql = "UPDATE projet 
            SET nom = :nom, 
                description = :description, 
                date_debut = :date_debut, 
                date_fin_prevue = :date_fin_prevue, 
                statut = :statut, 
                id_resp = :id_resp 
            WHERE id = :id";
    $stm = $this->pdo->prepare($sql);

    // Nettoyage des données
    $nom = htmlspecialchars(strip_tags($this->nom));
    $description = htmlspecialchars(strip_tags($this->description));
    $date_debut = htmlspecialchars(strip_tags($this->date_debut));
    $date_fin = htmlspecialchars(strip_tags($this->date_fin_prevue));
    $statut = htmlspecialchars(strip_tags($this->statut));
    $id_resp = htmlspecialchars(strip_tags($this->id_resp));

    // Bind des paramètres
    $stm->bindParam(':id', $id, PDO::PARAM_INT);
    $stm->bindParam(':nom', $nom);
    $stm->bindParam(':description', $description);
    $stm->bindParam(':date_debut', $date_debut);
    $stm->bindParam(':date_fin_prevue', $date_fin);
    $stm->bindParam(':statut', $statut);
    $stm->bindParam(':id_resp', $id_resp);

    // Exécution de la requête
    if ($stm->execute()) {
        return true;
    }
    return false;
}


public function updateProjetResp($id) {
    $sql = "UPDATE projet 
            SET nom = :nom, 
                description = :description, 
                date_debut = :date_debut, 
                date_fin_prevue = :date_fin_prevue, 
                statut = :statut
            WHERE id = :id";
    $sttm = $this->pdo->prepare($sql);

    // Nettoyage des données
    $nom = htmlspecialchars(strip_tags($this->nom));
    $description = htmlspecialchars(strip_tags($this->description));
    $date_debut = htmlspecialchars(strip_tags($this->date_debut));
    $date_fin = htmlspecialchars(strip_tags($this->date_fin_prevue));
    $statut = htmlspecialchars(strip_tags($this->statut));

    // Bind des paramètres
    $sttm->bindParam(':id', $id, PDO::PARAM_INT);
    $sttm->bindParam(':nom', $nom);
    $sttm->bindParam(':description', $description);
    $sttm->bindParam(':date_debut', $date_debut);
    $sttm->bindParam(':date_fin_prevue', $date_fin);
    $sttm->bindParam(':statut', $statut);

    // Exécution de la requête
    if ($sttm->execute()) {
        return true;
    }
    return false;
}


public function delet_projet($id) {
   
    // Supprimer les commentaires liés
$stmt1 = $this->pdo->prepare("DELETE FROM commentaire WHERE id_tache IN (SELECT id FROM tache WHERE id_projet = ?)");
$stmt1->execute([$id]);

// Supprimer les tâches liées
$stmt2 = $this->pdo->prepare("DELETE FROM tache WHERE id_projet = ?");
$stmt2->execute([$id]);

    $stmt = $this->pdo->prepare("DELETE FROM projet WHERE id = ?");
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        return true ;
    } else {
        return false ;
    }
}



}












?>