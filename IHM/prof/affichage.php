<?php
session_start();
include("../accueil.php");
require_once __DIR__ . "/../../Acces_BD/Professeur.php";

// Récupérer message éventuel
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';

$professeurs = getAllProfesseurs();
?>
<h2>Page Professeur</h2>
<p>Bienvenue sur la page d'affichage du professeur.</p>
<p>Vous pouvez gérer vos cours et vos étudiants ici.</p>

<?php if (isset($_SESSION['prof_message'])): ?>
    <div class="alert alert-success" role="alert">
        <?php 
        echo htmlspecialchars($_SESSION['prof_message']);
        unset($_SESSION['prof_message']);
        ?>
    </div>
<?php endif; ?>

<?php
if (isset($_GET['message'])) {
    echo '<p style="color:green;">' . htmlspecialchars($_GET['message']) . '</p>';
}
?>

<a href="form.php" class="btn btn-primary" style="margin-bottom: 20px; display: inline-block;">Ajouter un professeur</a>
<br>

<h3>Liste des professeurs :</h3>

<?php
// Vérifier que la requête a retourné un objet mysqli_result valide
if ($professeurs === null) {
    echo "<div style='color:red;'>Erreur de récupération des professeurs. Vérifiez les logs serveur (crud_prof.log / php_error_log).</div>";

    // Afficher les dernières lignes du log CRUD
    $logFile = __DIR__ . '/../../Acces_BD/crud_prof.log';
    if (is_readable($logFile)) {
        echo "<h4>Dernières lignes de crud_prof.log :</h4><pre>";
        $lines = @file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $last = $lines ? array_slice($lines, -50) : [];
        echo htmlspecialchars(implode("\n", $last));
        echo "</pre>";
    } else {
        echo "<div style='color:orange;'>crud_prof.log introuvable ou non lisible : $logFile</div>";
    }

    // Afficher les dernières lignes du log PHP (chemin XAMPP)
    $phpErr = 'C:\\xampp\\php\\logs\\php_error_log';
    if (is_readable($phpErr)) {
        echo "<h4>Dernières lignes de php_error_log :</h4><pre>";
        $lines = @file($phpErr, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $last = $lines ? array_slice($lines, -50) : [];
        echo htmlspecialchars(implode("\n", $last));
        echo "</pre>";
    } else {
        echo "<div style='color:orange;'>php_error_log introuvable ou non lisible : $phpErr</div>";
    }

} elseif ($professeurs instanceof mysqli_result && $professeurs->num_rows > 0) {
  
    echo '<table border="1" cellpadding="8" cellspacing="0">
      <tr>
        <th>Code</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Langues</th>
        <th>Spécialité</th>
        <th>Actions</th>
      </tr>';
    while ($row = $professeurs->fetch_assoc()) {
        $id = (int)$row['id'];
        echo "<tr>
                <td>" . htmlspecialchars($row['code']) . "</td>
                <td>" . htmlspecialchars($row['nom']) . "</td>
                <td>" . htmlspecialchars($row['prenom']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . htmlspecialchars($row['langues']) . "</td>
                <td>" . htmlspecialchars($row['specialite']) . "</td>
                <td>
                  <a href=\"form.php?id={$id}\">Modifier</a> |
                  <a href=\"supprimer.php?id={$id}\" onclick=\"return confirm('Confirmer la suppression ?');\">Supprimer</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    // Résultat valide mais vide
    echo "<div>Aucun professeur trouvé. <a href=\"form.php\">Ajouter un professeur</a></div>";
}
?>

<div style="margin-top: 30px; text-align: center;">
  <a href="../../logout.php" class="btn btn-danger" style="padding: 10px 20px; border-radius: 5px; text-decoration: none;">
    Déconnexion
  </a>
</div>
