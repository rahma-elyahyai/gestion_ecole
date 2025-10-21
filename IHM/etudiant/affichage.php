<?php
session_start();
include("../accueil.php");
include("../../Acces_BD/Etudiant.php");
$etudiants = getAllEtudiants();
?>
<h2>Page Étudiant</h2>
<p>Bienvenue sur la page d'affichage de l’étudiant.</p>
<p>Vous pouvez consulter vos cours et vos notes ici.</p>

<h3>Liste des étudiants :</h3>
<table border="1" cellpadding="8" cellspacing="0">
  <tr>
    <th>Nom</th>
    <th>Prénom</th>
  </tr>
<?php
while ($row = $etudiants->fetch_assoc()) {
    echo "  <tr><td>" . htmlspecialchars($row['nom']) . "</td><td>" . htmlspecialchars($row['prenom']) . "</td></tr>\n";
}
?>
</table>

<div style="margin-top: 30px; text-align: center;">
  <a href="../../logout.php" class="btn btn-danger" style="padding: 10px 20px; border-radius: 5px; text-decoration: none;">
    Déconnexion
  </a>
</div>
