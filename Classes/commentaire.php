<?php

class commentaire {

private $texte;
private $date;
private $id_auteur;
private $id_tache;
private $pdo; // Connexion à la base de données

function __construct($pdo, $texte='' ,$date='', $id_auteur='', $id_tache	='') {

    $this->texte=$texte;

    $this->date=$date;

    $this->id_auteur=$id_auteur;

    $this->id_tache=$id_tache;
    
    $this->pdo = $pdo; // Injection de dépendance pour PDO
    
 

}
// Getter et Setter pour texte
public function getTexte() {
    return $this->texte;
}

public function setTexte($texte) {
    $this->texte = $texte;
}

// Getter et Setter pour date
public function getDate() {
    return $this->date;
}

public function setDate($date) {
    $this->date = $date;
}

// Getter et Setter pour id_auteur
public function getIdAuteur() {
    return $this->id_auteur;
}

public function setIdAuteur($id_auteur) {
    $this->id_auteur = $id_auteur;
}

// Getter et Setter pour id_tache
public function getIdTache() {
    return $this->id_tache;
}

public function setIdTache($id_tache) {
    $this->id_tache = $id_tache;
}




//methode d'insertion
public function insert() {
    $query = "INSERT INTO commentaire (texte, date, id_tache, id_auteur) 
              VALUES (:texte, :date, :id_tache, :id_auteur)";
    $stmt = $this->pdo->prepare($query);

    // Nettoyage des données
    $texte = htmlspecialchars(strip_tags($this->texte));
    $date = htmlspecialchars(strip_tags($this->date));
    $id_tache = htmlspecialchars(strip_tags($this->id_tache));
    $id_auteur = htmlspecialchars(strip_tags($this->id_auteur));

    // Bind des paramètres
    $stmt->bindParam(":texte", $texte);
    $stmt->bindParam(":date", $date);
    $stmt->bindParam(":id_tache", $id_tache);
    $stmt->bindParam(":id_auteur", $id_auteur);

    // Exécution de la requête
    if ($stmt->execute()) {
        return true;
    }
    return false;
}





// public function updateCommentaire($id) {
//     $sql = "UPDATE commentaire 
//             SET texte = :texte, 
//                 date = :date, 
//                 id_tache = :id_tache, 
//                 id_auteur = :id_auteur 
//             WHERE id = :id";
//     $stm = $this->pdo->prepare($sql);

//     // Nettoyage des données
//     $texte = htmlspecialchars(strip_tags($this->texte));
//     $date = htmlspecialchars(strip_tags($this->date));
//     $id_tache = htmlspecialchars(strip_tags($this->id_tache));
//     $id_auteur = htmlspecialchars(strip_tags($this->id_auteur));

//     // Bind des paramètres
//     $stm->bindParam(':id', $id, PDO::PARAM_INT);
//     $stm->bindParam(':texte', $texte);
//     $stm->bindParam(':date', $date);
//     $stm->bindParam(':id_tache', $id_tache);
//     $stm->bindParam(':id_auteur', $id_auteur);

//     // Exécution de la requête
//     if ($stm->execute()) {
//         return true;
//     }
//     return false;
// }



// public function deleteCommentaire($id) {
//     $stmt = $this->pdo->prepare("DELETE FROM commentaire WHERE id = ?");
//     $stmt->execute([$id]);

//     if ($stmt->rowCount() > 0) {
//         return true;
//     } else {
//         return false;
//     }
// }



}












?>