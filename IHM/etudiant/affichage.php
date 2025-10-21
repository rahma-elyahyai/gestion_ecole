<?php
session_start();
include("../accueil.php");
include("../../Acces_BD/Etudiant.php");

$etudiants = getAllEtudiants();
?>
<h2>Page Étudiant</h2>
<p>Bienvenue sur la page d'affichage de l'étudiant.</p>
<p>Vous pouvez gérer vos cours et vos étudiants ici.</p>

<?php if (isset($_SESSION['etudiant_message'])): ?>
    <div class="alert alert-success" role="alert">
        <?php 
        echo htmlspecialchars($_SESSION['etudiant_message']);
        unset($_SESSION['etudiant_message']);
        ?>
    </div>
<?php endif; ?>

<!-- Ajout du bouton "Ajouter" -->
<div style="margin-bottom: 20px;">
    <a href="form.php" class="btn btn-primary">Ajouter un étudiant</a>
</div>

<table class="table table-bordered">
    <tr>
        <th>Code</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Sexe</th>
        <th>Filière</th>
        <th>Actions</th>
    </tr>
    <?php
    if ($etudiants) {
        while ($row = $etudiants->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['code']) . "</td>";
            echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
            echo "<td>" . htmlspecialchars($row['prenom']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['sexe']) . "</td>";
            echo "<td>" . htmlspecialchars($row['filiere']) . "</td>";
            echo "<td>";
            echo "<a href='form.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Modifier</a> ";
            echo "<a href='supprimer.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' 
                    onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet étudiant ?\");'>Supprimer</a>";
            echo "</td>";
            echo "</tr>";
        }
    }
    ?>
</table>

<div style="margin-top: 30px; text-align: center;">
    <a href="../../logout.php" class="btn btn-danger">Déconnexion</a>
</div>
