<?php
session_start();
include("../../Acces_BD/Etudiant.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$etudiant = $id ? getEtudiantById($id) : null;
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nettoyage des données
    $code   = trim($_POST['code'] ?? '');
    $nom    = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $sexe   = trim($_POST['sexe'] ?? '');
    $filiere= trim($_POST['filiere'] ?? '');

    if ($id) {
        // Modification
        $success = modifierEtudiant($id, $code, $nom, $prenom, $email, $sexe, $filiere);
        if ($success) {
            // redirection absolue vers la liste
            $_SESSION['etudiant_message'] = "Étudiant modifié avec succès";
            header("Location: affichage.php");
            exit;
        } else {
            $error = "Erreur lors de la modification (vérifier les logs).";
        }
    } else {
        // Ajout
        $newId = ajouterEtudiant($code, $nom, $prenom, $email, $sexe, $filiere);
        if ($newId) {
            // log action (optionnel si logAction existe)
            if (function_exists('logAction')) logAction('INSERT_ETUDIANT', ['id' => $newId, 'code'=>$code]);
            $_SESSION['etudiant_message'] = "Étudiant ajouté avec succès";
            header("Location: affichage.php");
            exit;
        } else {
            $error = "Erreur lors de l'ajout (vérifier le format de l'email et les logs).";
            if (function_exists('logAction')) logAction('ERROR_INSERT', ['code'=>$code,'email'=>$email]);
        }
    }
}
?>
<?php if ($error): ?>
    <div style="color:red;"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form method="post" action="">
    <div class="form-group">
        <label>Code:</label>
        <input type="text" name="code" value="<?php echo htmlspecialchars($etudiant['code'] ?? ''); ?>" required class="form-control">
    </div>
    <div class="form-group">
        <label>Nom:</label>
        <input type="text" name="nom" value="<?php echo htmlspecialchars($etudiant['nom'] ?? ''); ?>" required class="form-control">
    </div>
    <div class="form-group">
        <label>Prénom:</label>
        <input type="text" name="prenom" value="<?php echo htmlspecialchars($etudiant['prenom'] ?? ''); ?>" required class="form-control">
    </div>
    <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($etudiant['email'] ?? ''); ?>" required class="form-control">
    </div>
    <div class="form-group">
        <label>Sexe:</label>
        <select name="sexe" required class="form-control">
            <option value="M" <?php echo (($etudiant['sexe'] ?? '') == 'M') ? 'selected' : ''; ?>>Masculin</option>
            <option value="F" <?php echo (($etudiant['sexe'] ?? '') == 'F') ? 'selected' : ''; ?>>Féminin</option>
        </select>
    </div>
    <div class="form-group">
        <label>Filière:</label>
        <input type="text" name="filiere" value="<?php echo htmlspecialchars($etudiant['filiere'] ?? ''); ?>" required class="form-control">
    </div>
    <div class="form-group">
        <input type="submit" value="<?php echo $id ? 'Modifier' : 'Ajouter'; ?>" class="btn btn-primary">
        <a href="affichage.php" class="btn btn-secondary">Annuler</a>
    </div>
</form>
