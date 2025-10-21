<?php
include "connexion.php";
function getAllEtudiants() {
    $conn = Connect();
    $sql = "SELECT * FROM Etudiant";
    $result = $conn->query($sql);
    return $result;
}
?>
