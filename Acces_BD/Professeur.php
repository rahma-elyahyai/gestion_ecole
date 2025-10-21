<?php
include "connexion.php";
function getAllProfesseurs() {
    $conn = Connect();
    $sql = "SELECT * FROM Prof";
    $result = $conn->query($sql);
    return $result;
}
?>
