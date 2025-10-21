<?php
session_start();
include("../accueil.php");
include("../../Acces_BD/Professeur.php");
$professeurs = getAllProfesseurs();
?>
<h2>Page Professeur</h2>
<p>Bienvenue sur la page d'affichage du professeur.</p>
<p>Vous pouvez gérer vos cours et vos étudiants ici.</p>

<h3>Liste des professeurs :</h3>
<table border="1" cellpadding="8" cellspacing="0">
  <tr>
    <th>Nom</th>
    <th>Prénom</th>
    <th>Email</th>
    <th>Langues</th>
    <th>Spécialité</th>
  </tr>
<?php
while ($row = $professeurs->fetch_assoc()) {
    echo "<tr>
            <td>" . htmlspecialchars($row['nom']) . "</td>
            <td>" . htmlspecialchars($row['prenom']) . "</td>
            <td>" . htmlspecialchars($row['email']) . "</td>
            <td>" . htmlspecialchars($row['langues']) . "</td>
            <td>" . htmlspecialchars($row['specialite']) . "</td>
          </tr>";
}
?>
</table>

<div style="margin-top: 30px; text-align: center;">
  <a href="../../logout.php" class="btn btn-danger" style="padding: 10px 20px; border-radius: 5px; text-decoration: none;">
    Déconnexion
  </a>
</div>
