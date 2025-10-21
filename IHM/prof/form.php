<?php
session_start();
include("../../Acces_BD/Professeur.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$prof = $id ? getProfesseurById($id) : null;
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = trim($_POST['code'] ?? '');
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $langues = trim($_POST['langues'] ?? '');
    $specialite = trim($_POST['specialite'] ?? '');

    if ($id) {
        // Modification
        $success = modifierProfesseur($id, $code, $nom, $prenom, $email, $langues, $specialite);
        if ($success) {
            $_SESSION['prof_message'] = "Professeur modifié avec succès";
            header("Location: affichage.php");
            exit;
        } else {
            $error = "Erreur lors de la modification (vérifier les logs).";
        }
    } else {
        // Ajout
        $newId = ajouterProfesseur($code, $nom, $prenom, $email, $langues, $specialite);
        if ($newId) {
            $_SESSION['prof_message'] = "Professeur ajouté avec succès";
            header("Location: affichage.php");
            exit;
        } else {
            $error = "Erreur lors de l'ajout (vérifier les logs).";
        }
    }
}
?>

<?php if ($error): ?>
    <div style="color:red;"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form method="post" action="">
    <div>
        <label>Code:</label>
        <input type="text" name="code" value="<?php echo htmlspecialchars($prof['code'] ?? ''); ?>" required>
    </div>
    <div>
        <label>Nom:</label>
        <input type="text" name="nom" value="<?php echo htmlspecialchars($prof['nom'] ?? ''); ?>" required>
    </div>
    <div>
        <label>Prénom:</label>
        <input type="text" name="prenom" value="<?php echo htmlspecialchars($prof['prenom'] ?? ''); ?>" required>
    </div>
    <div>
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($prof['email'] ?? ''); ?>" required>
    </div>
    <div>
        <label>Langues:</label>
        <input type="text" name="langues" value="<?php echo htmlspecialchars($prof['langues'] ?? ''); ?>">
    </div>
    <div>
        <label>Spécialité:</label>
        <input type="text" name="specialite" value="<?php echo htmlspecialchars($prof['specialite'] ?? ''); ?>">
    </div>
    <div>
        <input type="submit" value="<?php echo $id ? 'Modifier' : 'Ajouter'; ?>">
        <a href="affichage.php">Annuler</a>
    </div>
</form>
