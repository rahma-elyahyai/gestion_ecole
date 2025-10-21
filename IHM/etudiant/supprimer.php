<?php
session_start();
include("../../Acces_BD/Etudiant.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

if ($id) {
    $success = supprimerEtudiant($id);
    if ($success) {
        $_SESSION['etudiant_message'] = "Étudiant supprimé avec succès";
    } else {
        $_SESSION['etudiant_message'] = "Erreur lors de la suppression";
    }
} else {
    $_SESSION['etudiant_message'] = "ID invalide";
}

header("Location: affichage.php");
exit;
?>
