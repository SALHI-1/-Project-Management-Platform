<?php

class tache {

    	
private $nom;
private $description;
private $date_debut;
private $date_fin_prevue;

private $date_fin_reelle;

private $statut;

private $priorite;
private $id_resp;

private $id_projet;
private $pdo; // Connexion à la base de données

public function __construct($pdo, $nom = null, $description = null, $date_debut = null, $date_fin_prevue = null, $date_fin_reelle = null, $statut = null, $priorite = null, $id_resp = null, $id_projet = null) {
    $this->pdo = $pdo;
    $this->nom = $nom;
    $this->description = $description;
    $this->date_debut = $date_debut;
    $this->date_fin_prevue = $date_fin_prevue;
    $this->date_fin_reelle = $date_fin_reelle;
    $this->statut = $statut;
    $this->priorite = $priorite;
    $this->id_resp = $id_resp;
    $this->id_projet = $id_projet;
}

   // Getters et Setters
   public function getNom() {
    return $this->nom;
}

public function setNom($nom) {
    $this->nom = $nom;
}

public function getDescription() {
    return $this->description;
}

public function setDescription($description) {
    $this->description = $description;
}

public function getDateDebut() {
    return $this->date_debut;
}

public function setDateDebut($date_debut) {
    $this->date_debut = $date_debut;
}

public function getDateFinPrevue() {
    return $this->date_fin_prevue;
}

public function setDateFinPrevue($date_fin_prevue) {
    $this->date_fin_prevue = $date_fin_prevue;
}

public function getDateFinReelle() {
    return $this->date_fin_reelle;
}

public function setDateFinReelle($date_fin_reelle) {
    $this->date_fin_reelle = $date_fin_reelle;
}

public function getStatut() {
    return $this->statut;
}

public function setStatut($statut) {
    $this->statut = $statut;
}

public function getPriorite() {
    return $this->priorite;
}

public function setPriorite($priorite) {
    $this->priorite = $priorite;
}

public function getIdResp() {
    return $this->id_resp;
}

public function setIdResp($id_resp) {
    $this->id_resp = $id_resp;
}

public function getIdProjet() {
    return $this->id_projet;
}

public function setIdProjet($id_projet) {
    $this->id_projet = $id_projet;
}

public function getPdo() {
    return $this->pdo;
}

public function setPdo($pdo) {
    $this->pdo = $pdo;
}




public function insert_tache() {
    $query = "INSERT INTO tache (nom, description, date_debut, date_fin_prevue, date_fin_reelle, statut, priorite, id_projet, id_affectataire) 
              VALUES (:nom, :description, :date_debut, :date_fin_prevue, :date_fin_reelle, :statut, :priorite, :id_projet, :id_affectataire)";
    $stmt = $this->pdo->prepare($query);

    // Nettoyage des données
    $nom = htmlspecialchars(strip_tags($this->nom));
    $description = htmlspecialchars(strip_tags($this->description));
    $date_debut = htmlspecialchars(strip_tags($this->date_debut));
    $date_fin_prevue = htmlspecialchars(strip_tags($this->date_fin_prevue));
    $date_fin_reelle = htmlspecialchars(strip_tags($this->date_fin_reelle));
    $statut = htmlspecialchars(strip_tags($this->statut));
    $priorite = htmlspecialchars(strip_tags($this->priorite));
    $id_projet = htmlspecialchars(strip_tags($this->id_projet));
    $id_resp = htmlspecialchars(strip_tags($this->id_resp));

    // Bind des paramètres
    $stmt->bindParam(":nom", $nom);
    $stmt->bindParam(":description", $description);
    $stmt->bindParam(":date_debut", $date_debut);
    $stmt->bindParam(":date_fin_prevue", $date_fin_prevue);
    $stmt->bindParam(":date_fin_reelle", $date_fin_reelle);
    $stmt->bindParam(":statut", $statut);
    $stmt->bindParam(":priorite", $priorite);
    $stmt->bindParam(":id_projet", $id_projet);
    $stmt->bindParam(":id_affectataire", $id_resp);

    // Exécution de la requête
    if ($stmt->execute()) {
        return true;
    }
    return false;
}





public function updatetache($id) {
    $sql = "UPDATE tache 
            SET nom = :nom, 
                description = :description, 
                date_debut = :date_debut, 
                date_fin_prevue = :date_fin_prevue, 
                date_fin_reelle = :date_fin_reelle, 
                statut = :statut, 
                priorite = :priorite, 
                id_projet = :id_projet, 
                id_affectataire = :id_affectataire 
            WHERE id = :id";

    $stm = $this->pdo->prepare($sql);

    // Nettoyage des données
    $nom = htmlspecialchars(strip_tags($this->nom));
    $description = htmlspecialchars(strip_tags($this->description));
    $date_debut = htmlspecialchars(strip_tags($this->date_debut));
    $date_fin_prevue = htmlspecialchars(strip_tags($this->date_fin_prevue));
    $date_fin_reelle = htmlspecialchars(strip_tags($this->date_fin_reelle));
    $statut = htmlspecialchars(strip_tags($this->statut));
    $priorite = htmlspecialchars(strip_tags($this->priorite));
    $id_projet = htmlspecialchars(strip_tags($this->id_projet));
    $id_affectataire = htmlspecialchars(strip_tags($this->id_resp));

    // Bind des paramètres
    $stm->bindParam(":id", $id, PDO::PARAM_INT);
    $stm->bindParam(":nom", $nom);
    $stm->bindParam(":description", $description);
    $stm->bindParam(":date_debut", $date_debut);
    $stm->bindParam(":date_fin_prevue", $date_fin_prevue);
    $stm->bindParam(":date_fin_reelle", $date_fin_reelle);
    $stm->bindParam(":statut", $statut);
    $stm->bindParam(":priorite", $priorite);
    $stm->bindParam(":id_projet", $id_projet);
    $stm->bindParam(":id_affectataire", $id_affectataire);

    // Exécution de la requête
    if ($stm->execute()) {
        return true;
    }
    return false;
}


public function update_statue_tache($id,$statut) {
    $stmt = $this->pdo->prepare("UPDATE tache SET statut = :statut WHERE id = :id");
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->bindParam(":statut", $statut);

 
      // Exécution de la requête
    if ($stmt->execute()) {
        return true;
    }
    return false;
}
 




public function delet_tache($id) {
   $sttmt = $this->pdo->prepare("DELETE FROM commentaire WHERE id_tache = ?");
    $sttmt->execute([$id]);

    $sttmt = $this->pdo->prepare("DELETE FROM tache WHERE id = ?");
    $sttmt->execute([$id]);
   
    

    if ($sttmt->rowCount() > 0 && $sttmt->rowCount() > 0) {
        return true ;
    } else {
        return false ;
    }
}


}













?>