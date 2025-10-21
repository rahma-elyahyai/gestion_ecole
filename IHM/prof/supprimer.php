<?php
session_start();
include("../../Acces_BD/Professeur.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

if ($id) {
    $success = supprimerProfesseur($id);
    if ($success) {
        $_SESSION['prof_message'] = "Professeur supprimé avec succès";
    } else {
        $_SESSION['prof_message'] = "Erreur lors de la suppression";
    }
} else {
    $_SESSION['prof_message'] = "ID invalide";
}

header("Location: affichage.php");
exit;
?>